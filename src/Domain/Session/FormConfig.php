<?php

declare(strict_types=1);

namespace SensioLabs\Live2Vod\Api\Domain\Session;

use SensioLabs\Live2Vod\Api\Domain\Session\Form\Actions;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Buttons;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Name;
use SensioLabs\Live2Vod\Api\Domain\Session\Form\Validations;
use Webmozart\Assert\Assert;

/**
 * @phpstan-import-type ButtonsArray from Buttons
 * @phpstan-import-type ActionsArray from Actions
 * @phpstan-import-type ValidationsArray from Validations
 *
 * @phpstan-type FormConfigArray array{clipTitleField?: ?string, buttons?: ButtonsArray, actions?: ActionsArray, validations?: ValidationsArray}
 */
final class FormConfig
{
    public function __construct(
        private ?Name $clipTitleField = null,
        private Buttons $buttons = new Buttons(),
        private Actions $actions = new Actions(),
        private Validations $validations = new Validations(),
    ) {
        Assert::maxCount(
            $this->buttons,
            2,
            'Form config supports a maximum of 2 buttons, got %d.',
        );
    }

    public function getClipTitleField(): ?Name
    {
        return $this->clipTitleField;
    }

    public function getButtons(): Buttons
    {
        return $this->buttons;
    }

    public function getActions(): Actions
    {
        return $this->actions;
    }

    public function getValidations(): Validations
    {
        return $this->validations;
    }

    /**
     * @param FormConfigArray $data
     */
    public static function fromArray(array $data): self
    {
        $clipTitleField = $data['clipTitleField'] ?? null;

        return new self(
            clipTitleField: \is_string($clipTitleField) ? new Name($clipTitleField) : null,
            buttons: isset($data['buttons']) ? Buttons::fromArray($data['buttons']) : new Buttons(),
            actions: isset($data['actions']) ? Actions::fromArray($data['actions']) : new Actions(),
            validations: isset($data['validations']) ? Validations::fromArray($data['validations']) : new Validations(),
        );
    }

    /**
     * @return FormConfigArray
     */
    public function toArray(): array
    {
        return [
            'clipTitleField' => $this->clipTitleField?->toString(),
            'buttons' => $this->buttons->toArray(),
            'actions' => $this->actions->toArray(),
            'validations' => $this->validations->toArray(),
        ];
    }
}
