<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Factory\Webhook\Event;

use SensioLabs\Live2Vod\Api\Domain\Clip\Status;
use Symfony\Component\Uid\Ulid;
use Zenstruck\Foundry\ArrayFactory;

final class ClipErrorEventFactory extends ArrayFactory
{
    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $markInDateTime = \DateTimeImmutable::createFromMutable(self::faker()->dateTime());
        $markOutDateTime = $markInDateTime->modify('+1 hour');

        return [
            'sessionId' => (string) new Ulid(),
            'clipId' => (string) new Ulid(),
            'status' => Status::ERROR->value,
            'position' => self::faker()->numberBetween(1, 10),
            'last' => self::faker()->boolean(),
            'markIn' => $markInDateTime->format('Y-m-d\TH:i:s.v\Z'),
            'markOut' => $markOutDateTime->format('Y-m-d\TH:i:s.v\Z'),
            'formData' => [
                'title' => self::faker()->sentence(),
                'description' => self::faker()->optional()->paragraph(),
            ],
            'assets' => null,
        ];
    }
}
