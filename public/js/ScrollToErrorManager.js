/**
 * Manage error-catching actions, so that when an error occurs in a field upon submission
 * The page will automatically scroll to that field
 * Focus on it for easy input without the need for the user to click on it again
 * 
 * Within a container, for fields that need to be scrolled to when an error occurs 
 * add the attribute 'data-check-error' to those fields. 
 * Handle it so that if there's an error, the value of the attribute 'data-check-error' is set to 'error'. 
 * Then, during initialization of the view, simply call this new class and pass in the container containing the fields to be validated
 * 
 * Exp: 
 * <input id="student-nums-input" type="number" class="form-control" data-check-error="{{ $errors->has('num_of_student') ? 'error' : 'none' }}"
 * ...
 * 
 * new ScrollToErrorManager({
 *      container: document.querySelector('#{{ $createTrainOrderItemPopupUniqid }}')
 * });
 * 
 */
class ScrollToErrorManager {
    constructor(options) {
        this.container = options.container;
        this.scrollToFirstError();
    };

    getErrorElements() {
        return this.container.querySelectorAll('[data-check-error="error"]');
    };

    scrollToFirstError() {
        const errorElements = this.getErrorElements();

        if (errorElements.length > 0) {
            const firstErrorElement = errorElements[0];
            const offsetTop = firstErrorElement.offsetTop;

            if (firstErrorElement.tagName.toLowerCase() === 'input') {
                firstErrorElement.focus();
            } else if (firstErrorElement.tagName.toLowerCase() === 'select') {
                const event = new Event('mousedown', {
                    bubbles: true
                });

                firstErrorElement.dispatchEvent(event);

                firstErrorElement.selectedIndex = 0;

                const changeEvent = new Event('change', {
                    bubbles: true
                });

                firstErrorElement.dispatchEvent(changeEvent);
            }

            document.querySelector('[modal-container]').scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
        };
    };
};