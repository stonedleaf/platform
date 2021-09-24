import ApplicationController from './application_controller'

export default class extends ApplicationController {
    /**
     * @type {string[]}
     */

     static targets = [
        "upload"
    ];

    /**
     *
     */
    connect() {
        let image = this.data.get('url') ? this.data.get('url') : null

        if (image) {
            this.element.querySelector('.picture-raw-preview').src = image;
            this.element.querySelector('.picture-raw-removechecker').value = 0;
            return;
        }

        this.element.querySelector('.picture-raw-preview').classList.add('none');
        this.element.querySelector('.picture-raw-remove').classList.add('none');
    }

    /**
     * Event for uploading image
     *
     * @param event
     */
    upload(event) {
        if (!event.target.files[0]) {
            return;
        }

        let maxFileSize = this.data.get('max-file-size');
        if (event.target.files[0].size / 1024 / 1024 > maxFileSize) {
            this.alert('Validation error', `The download file is too large. Max size: ${maxFileSize} MB`);
            event.target.value = null;
            return;
        }

        let reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);

        reader.onloadend = () => {
            let element = this.element;

            element.querySelector('.picture-raw-preview').src = reader.result;
            element.querySelector('.picture-raw-preview').classList.remove('none');
            element.querySelector('.picture-raw-remove').classList.remove('none');
            $(element.querySelector('.modal')).modal('hide');

            if (this.data.get('url')) {
                this.element.querySelector('.picture-raw-removechecker').value = 1;
            } else {
                element.querySelector('.picture-raw-removechecker').value = 0;
            }
        };

    }

    /**
     *
     */
    clear() {
        if (this.data.get('url')) {
            this.element.querySelector('.picture-raw-removechecker').value = 1;
        }

        this.element.querySelector('.picture-raw-uploader').value = null;
        this.element.querySelector('.picture-raw-preview').src = '';
        this.element.querySelector('.picture-raw-preview').classList.add('none');
        this.element.querySelector('.picture-raw-remove').classList.add('none');
    }
}
