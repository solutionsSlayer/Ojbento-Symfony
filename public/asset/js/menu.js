$(document).ready(function(){

    var $collectionHolder;
    var $addItemButton = $('<button type= "button" class="mt-3 btn btn-danger btn-rounded btn-sm my-0 add_item_link">Ajouter un produit </button>');
    var $newPrice = $('<div></div>').append($addItemButton);

    $collectionHolder = $('#menu_assocs');
    $collectionHolder.append($newPrice);

    $collectionHolder.find('.assoc').each(function(){
        addPriceFormDelete($(this));
    });
    $collectionHolder.data('index', $collectionHolder.find('.assoc').length);
    $addItemButton.on('click',function(e){
        addMenuFrom($collectionHolder, $newPrice);
    });
});

function addAssocFormDelete(arg){
    var $removeFormButton = $('<button class="mt-3 btn btn-danger btn-rounded btn-sm my-0" type="button">Supprimer le produit</button>');
    arg.append($removeFormButton);
    $removeFormButton.on('click', function(e){
        arg.remove();
    });
}

function addMenuFrom($collectionHolder, $newItemLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<div></div>').append(newForm);
    $newItemLi.before($newFormLi);
    addAssocFormDelete($newFormLi);
    $('.forAssoc').remove();
    $('.forMenu').val('1');
}

var $collectionHolder;
var $addItemButton = $('<button type= "button" class="mt-3 btn btn-danger btn-rounded btn-sm my-0 add_item_link">Ajouter un prix </button>');
var $newPrice = $('<div></div>').append($addItemButton);

$collectionHolder = $('#menu_prices');
$collectionHolder.append($newPrice);

$collectionHolder.find('.prices').each(function(){
    addPriceFormDelete($(this));
});
$collectionHolder.data('index', $collectionHolder.find('.prices').length);
$addItemButton.on('click',function(e){
    addPriceFrom($collectionHolder, $newPrice);
});


function addPriceFormDelete(arg){
    var $removeFormButton = $('<button class="mt-3 btn btn-danger btn-rounded btn-sm my-0" type="button">Supprimer le prix</button>');
    arg.append($removeFormButton);
    $removeFormButton.on('click', function(e){
        arg.remove();
    });
}

function addPriceFrom($collectionHolder, $newItemLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLi = $('<div></div>').append(newForm);
    $newItemLi.before($newFormLi);
    addPriceFormDelete($newFormLi);
}
