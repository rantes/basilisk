/**
 * @dmbdoc directive
 * @name DMB.directive:DmbCard
 *
 * @description
 * This directive only will contains the data, the directive is set to add proper styles and further behaviors.
 *
 * @example
 <dmb-card></dmb-card>
 */
class DmbCard extends DumboDirective {
    constructor() {
        super();
    }
}

customElements.define('dmb-card', DmbCard);