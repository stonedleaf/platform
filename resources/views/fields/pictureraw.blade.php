@component($typeForm, get_defined_vars())
    <div data-controller="picture-raw"
         data-picture-raw-max-file-size="{{ $maxFileSize }}"
         data-picture-raw-url="{{ $url }}"
    >
        <div class="border-dashed text-end p-3 picture-actions">

            <div class="fields-picture-container">
                <img src="#" class="picture-raw-preview img-fluid img-full mb-2 border" alt="">
            </div>

            <span class="mt-1 float-start">{{ __('Upload image from your computer:') }}</span>

            <div class="btn-group">
                <label class="btn btn-default m-0">
                    <x-orchid-icon path="cloud-upload" class="me-2"/>

                    {{ __('Browse') }}
                    <input type="file"
                           accept="image/*"
                           data-target="picture-raw.upload"
                           data-action="change->picture-raw#upload"
                           {{ $attributes }}
                           style="display: none !important;"
                           class="d-none picture-raw-uploader">
                    <input type="hidden"
                        class="picture-raw-removechecker"
                        name="{{ $removeInputName }}"
                        value="0">
                </label>

                <button type="button" class="btn btn-outline-danger picture-raw-remove"
                        data-action="picture-raw#clear">{{ __('Remove') }}</button>
            </div>
        </div>
    </div>
@endcomponent
