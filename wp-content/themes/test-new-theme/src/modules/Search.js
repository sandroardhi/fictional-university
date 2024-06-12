import $ from "jquery";

class Search {
  // constructor to describe and create/initiate our object
  constructor() {
    this.addSearchHTML();
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.searchField = $("#search-term");
    this.events();
    this.isOverlayOpen = false;
    this.typingTimer;
    this.resultsDiv = $("#search-overlay__results");
    this.isSpinnerVisible = false;
    this.previousValue;
  }

  // events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    $(document).on("keyup", this.keyPressDispatcher.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }
  // end of events

  // methods
  typingLogic() {
    // check if the current input value is the same or not with previous value so that we wont trigger the call when user press key on keyboard that doesnt change the input value
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      //   check if the input field is completely empty or not
      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 500);
      } else {
        this.resultsDiv.html("");
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.val();
  }
  getResults() {
    $.when(
      $.getJSON(
        universityData.root_url +
          "/wp-json/wp/v2/posts?search=" +
          this.searchField.val()
      ),
      $.getJSON(
        universityData.root_url +
          "/wp-json/wp/v2/pages?search=" +
          this.searchField.val()
      )
    ).then((posts, pages) => {
      var combinedResults = posts[0].concat(pages[0]);
      this.resultsDiv.html(`
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              combinedResults.length
                ? `<ul class="link-list min-list">
                        ${combinedResults
                          .map(
                            (item) =>
                              `<li><a href="${item.link}">${item.title.rendered}</a>${item.type == 'post' ? ` by ${item.authorName}` : '' } </li>`
                          )
                          .join("")}
                    </ul>`
                : `<p>Nothing general information matches your search</p>`
            }
            `);
      this.isSpinnerVisible = false;
    }, () => {
        this.resultsDiv.html('Unexpected problem, please try again')
    });

    $.getJSON(
      universityData.root_url +
        "/wp-json/wp/v2/posts?search=" +
        this.searchField.val(),
      (posts) => {}
    );
  }
  keyPressDispatcher(e) {
    // the third argument is to make sure this wont trigger if the user is inside of an input field somewhere else on the web
    if (
      e.key == "s" &&
      !this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
      this.openOverlay();
    }
    if (
      e.key == "Escape" &&
      this.isOverlayOpen &&
      !$("input, textarea").is(":focus")
    ) {
      this.closeOverlay();
    }
  }
  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    this.isOverlayOpen = true;
    this.searchField.val("");
    setTimeout(() => {
      this.searchField.focus();
    }, 301);
  }
  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    this.isOverlayOpen = false;
  }
  addSearchHTML() {
    $("body").append(`
    <div class="search-overlay">
        <div class="search-overlay__top">
            <div class="container">
                <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                <input autocomplete="off" type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
                <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
            </div>
        </div>

        <div class="container">
            <div id="search-overlay__results">

            </div>
        </div>
    </div>`);
  }
  // end of methods
}

export default Search;
