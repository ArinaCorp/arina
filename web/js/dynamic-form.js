jQuery.fn.dynamicForm = function (options) {
    /** Options fetch **/
    options = options || {};
    var newItemPrefix = options['newItemPrefix'] || 'new_';
    var indexPlaceholder = options['indexPlaceholder'] || 'ITEM_INDEX';

    /** Init **/
    var container = jQuery(this);
    var items = container.find('.items');
    var formTemplate = container.find('.form-template');
    var htmlFormTemplate;

    /** Check if template is exist **/
    if (formTemplate.length === 0) {
        console.error('Please provide form template');
    } else {
        htmlFormTemplate = formTemplate.html();
        /** Remove template node to prevent excess data sending **/
        formTemplate.remove();
    }

    /** Find available new item index **/
    var index = getLastIndex();

    function getLastIndex() {
        var index = 0;
        items.find('.item').each(function (_index, itemEl) {
            var key = jQuery(itemEl).data('key');
            if (typeof key === 'string' && key.startsWith(newItemPrefix)) {
                index = Math.max(index, parseInt(key.replace(newItemPrefix, '')));
            }
        });
        return index;
    }

    /** Take template html, replace index placeholders and returns item object for inserting **/
    function getNewItem() {
        index++;
        var html = htmlFormTemplate.replaceAll(indexPlaceholder, index);
        return jQuery(html);
    }

    /** Add button handler **/
    container.on('click', '.add-item', function (e) {
        var newItem = getNewItem();
        container.trigger('before-add.dynamic-form', {item: newItem});
        items.append(newItem);
        container.trigger('after-add.dynamic-form', {item: newItem});

        e.preventDefault(e);
        return false;
    });

    /** Remove button handler **/
    container.on('click', '.remove-item', function (e) {
        var btn = jQuery(this);
        const item = btn.closest('.item');
        container.trigger('before-remove.dynamic-form', {item: item});
        item.remove();
        container.trigger('after-remove.dynamic-form', {item: item});

        e.preventDefault(e);
        return false;
    });

};