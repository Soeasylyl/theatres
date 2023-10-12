
class header {
    constructor() {
        this.getHeader = document.getElementById('headerId');
        this.logoWrapper = document.querySelector('.header-wrapper__logo');
        this.svgElement = this.logoWrapper.querySelector('svg');
        this.headerWrapper = document.querySelector('.header-wrapper');

        this.init();
    }

    init() {
        this.resizeHeader();
    }

    resizeHeader() {
        window.addEventListener("scroll", () => {
            if (window.pageYOffset > 50) {
                this.getHeader && this.getHeader.classList.add("small-size-header", "header-background");
                this.headerWrapper && this.headerWrapper.classList.add("small-size-header")
                this.svgElement && this.svgElement.classList.add("small-logo");
            } else {
                this.getHeader && this.getHeader.classList.remove("small-size-header", "header-background");
                this.headerWrapper && this.headerWrapper.classList.remove("small-size-header")
                this.svgElement && this.svgElement.classList.remove("small-logo");
            }
        });
    }
}

new header();
