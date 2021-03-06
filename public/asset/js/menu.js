
    var $assocCollection;
    var $addMenuButton = $('<button type= "button" class="mt-3 btn btn-danger btn-rounded btn-sm my-0 add_item_link">+ Ajouter un produit </button>');
    var $newAssoc = $('<div></div>').append($addMenuButton);
var indexMenu= 0;

    $assocCollection = $('#menu_assocs');
    $assocCollection.append($newAssoc);

    $assocCollection.find('.assoc').each(function(){
        addPriceFormDelete($(this));
    });
    $assocCollection.data('index', $assocCollection.find('.assoc').length);
    $addMenuButton.on('click',function(e){
        addMenuFrom($assocCollection, $newAssoc);
    });

function addAssocFormDelete(arg){
    var $removeFormButton = $('<button class="mt-3 btn btn-danger btn-rounded btn-sm my-0" type="button">- Supprimer le produit</button>');
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

    if ($('.test').length > 1){
        addAssocFormDelete($newFormLi);
    }

    $('.forAssoc').remove();
    $('.forMenu').val('1');
}
    $('.forAssoc').remove();
var $collectionHolder;
var $addItemButton = $('<button type= "button" class="mt-3 btn btn-danger btn-rounded btn-sm my-0 add_item_link">+ Ajouter un prix </button>');
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
    var $removeFormButton = $('<button class="mt-3 btn btn-danger btn-rounded btn-sm my-0" type="button">- Supprimer le prix</button>');
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
    if ($('.price-value').length > 1){
        addPriceFormDelete($newFormLi);
    }
}
