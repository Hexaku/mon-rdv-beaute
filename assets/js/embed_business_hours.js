

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
const jQuery = require('jquery');
require('bootstrap');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

let $collectionHolder;

// setup an "add a tag" link
const $addTagButton = $('<button type="button" class="add_tag_link btn btn-primary">Ajouter un horaire</button>');
const $newLinkLi = $('<p></p>').append($addTagButton);

function addTagFormDeleteLink($tagFormLi) {
    const $removeFormButton = $('<button type="button" class="btn btn-danger">Supprimer l\'horaire</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', (e) => {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

// eslint-disable-next-line no-shadow
function addTagForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    const prototype = $collectionHolder.data('prototype');

    // get the new index
    const index = $collectionHolder.data('index');
    let newForm = prototype;
    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    const $newFormLi = $('<p></p>').append(newForm);
    $newLinkLi.before($newFormLi);

    addTagFormDeleteLink($newFormLi);
}

jQuery(document).ready(() => {
    // Get the ul that holds the collection of hours
    $collectionHolder = $('div.hours');

    // add a delete link to all of the existing tag form li elements
    /* eslint-disable */
    $collectionHolder.find('div.current').each(function () {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the hours ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagButton.on('click', function (e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});
