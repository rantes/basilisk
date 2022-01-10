/**
 * @dmbdoc directive
 * @name DMB.directive:DmbMoreOptions
 *
 * @description
 * Wrapper handler for the group of muy-option items. Render an icon (three vertical points) and on click display the options.
 *
 * @example
<dmb-more-options>
    <dmb-more-option
        behavior="open-panel"
        url="/url/to/run/action"
        panel="#panel-to-open">
    </dmb-more-option>
    <dmb-more-option
        behavior="open-panel"
        url="/url/to/run/action"
        panel="#panel-to-open">
    </dmb-more-option>
</dmb-more-options>
 */
class DmbMoreOptions extends DumboDirective {
    constructor() {
        super();

        const template = '<div class="wrapper" transclude></div>';
        this.setTemplate(template);
        this.wrapper = null;
        this.option = document.createElement('dmb-more-option');
    }

    init() {
        this.wrapper = this.querySelector('.wrapper');
        this.classList.add('icon');
        this.classList.add('icon-more_vert');
        this.addEventListener('click', (e) => {
            e.preventDefault();
            this.wrapper.classList.toggle('active');
        });

        this.buildOptions();
    }

    setOptions(options) {
        if (!Array.isArray(options)) {
            throw 'Options must to be an array';
        }
        this.options = options;
        this.buildOptions();
    }

    buildOptions() {
        let size = 0;
        let i = 0;
        let option = null;

        if (this.options && Array.isArray(this.options)) {
            size = this.options.length;
            for (i = 0; i < size; i++) {
                option = this.option.cloneNode();
                option.innerHTML = this.options[i].text;

                if (this.options[i].behavior) option.setAttribute(this.options[i].behavior);
                if (this.options[i].url) option.setAttribute(this.options[i].url);
                if (this.options[i].panel) option.setAttribute(this.options[i].panel);

                this.wrapper.appendChild(option);
            }
        }
    }
}

customElements.define('dmb-more-options', DmbMoreOptions);