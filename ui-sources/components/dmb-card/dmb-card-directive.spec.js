describe('DmbCard Directive', () => {
    let element = null;

    element = document.createElement('dmb-card');
    document.body.append(element);

    it('Should render element', () => {
        expect(element).toBeDefined();
    });
});