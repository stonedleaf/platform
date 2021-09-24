<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;
use Orchid\Support\Init;

class PictureRaw extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.pictureraw';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'url'         => null,
        'maxFileSize' => null,
        'removeInputName' => null,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'name',
        'placeholder',
        'readonly',
        'required',
        'tabindex',
    ];

    /**
     * Picture constructor.
     */
    public function __construct()
    {
        // Set max file size
        $this->addBeforeRender(function () {
            $this->setRemoveCheckerName();

            $maxFileSize = $this->get('maxFileSize');

            $serverMaxFileSize = Init::maxFileUpload(Init::MB);

            if ($maxFileSize === null) {
                $this->set('maxFileSize', $serverMaxFileSize);

                return;
            }

            throw_if(
                $maxFileSize > $serverMaxFileSize,
                'Cannot set the desired maximum file size. This contradicts the settings specified in .ini');
        });
    }

    /**
     * Set image preview url
     * 
     * @param string|null $url
     * 
     * @return self
     */
    public function previewUrl($url): self
    {
        $this->set('url', $url);

        return $this;
    }

    /**
     * Set _isRemoved field name based on original field name
     * 
     * @return void
     */
    private function setRemoveCheckerName()
    {
        $result = '_isRemoved';
        $name = $this->get('name');

        if (substr($name, -1) == ']') {
            $result = substr($name, 0, -1).$result.']';
        } else {
            $result = $name.$result;
        }

        $this->set('removeInputName', $result);
    }
}
