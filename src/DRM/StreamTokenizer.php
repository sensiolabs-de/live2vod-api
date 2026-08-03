<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\DRM;

use SensioLabs\Live2Vod\Api\Domain\Clip\Assets;
use SensioLabs\Live2Vod\Api\Domain\Clip\Stream;
use SensioLabs\Live2Vod\Api\Domain\DRM\Acl;
use SensioLabs\Live2Vod\Api\Domain\DRM\GeoLocation;
use Safe\DateTimeImmutable;
use Webmozart\Assert\Assert;
use function Safe\parse_url;

/**
 * Tokenizes stream URLs by deriving "begin_rec"/"end_rec" from the URL itself.
 *
 * ORS validates that the "begin"/"end" query parameters of a playback URL are
 * identical to the "begin_rec"/"end_rec" fields of the "tk_ors" token. Generating
 * the token from any other source (e.g. markIn/markOut or a session start time)
 * risks a mismatch that makes the stream unplayable. Deriving the values from the
 * URL guarantees they match by construction.
 */
final readonly class StreamTokenizer implements StreamTokenizerInterface
{
    /**
     * Basic ISO 8601 format used by ORS playback URLs, e.g. "20260731T164311".
     * The "!" resets all unparsed fields (fractional seconds) to zero.
     */
    private const string TIME_FORMAT = '!Ymd\THis';

    public function __construct(private TokenGeneratorInterface $tokenGenerator)
    {
    }

    public function tokenize(Stream $stream, Acl $acl, GeoLocation $geoLocation): Stream
    {
        $url = $stream->getUrl()->toString();

        $query = parse_url($url, \PHP_URL_QUERY);
        Assert::string($query, \sprintf('Stream URL "%s" has no query string.', $url));

        parse_str($query, $parameters);

        return $stream->withToken($this->tokenGenerator->generate(
            acl: $acl,
            geoLocation: $geoLocation,
            beginRec: self::parseTime($parameters, 'begin', $url),
            endRec: self::parseTime($parameters, 'end', $url),
        ));
    }

    public function tokenizeAssets(Assets $assets, Acl $acl, GeoLocation $geoLocation): Assets
    {
        $streams = array_map(
            fn (Stream $stream): Stream => $this->tokenize($stream, $acl, $geoLocation),
            $assets->getStreams(),
        );

        return $assets->withStreams($streams);
    }

    /**
     * @param array<int|string, array<mixed>|string> $parameters
     */
    private static function parseTime(array $parameters, string $name, string $url): DateTimeImmutable
    {
        Assert::keyExists($parameters, $name, \sprintf('Stream URL "%s" has no "%s" query parameter.', $url, $name));

        $value = $parameters[$name];
        Assert::string($value, \sprintf('Query parameter "%s" of stream URL "%s" must be a string.', $name, $url));
        Assert::regex($value, '/^\d{8}T\d{6}$/', \sprintf('Query parameter "%s" of stream URL "%s" must match the format "Ymd\THis".', $name, $url));

        return DateTimeImmutable::createFromFormat(self::TIME_FORMAT, $value, new \DateTimeZone('UTC'));
    }
}
