document.observe("dom:loaded", function()
{
    $('catalog_category_products_table').down('tbody').setAttribute('id', 'catalog_category_products_table_tbody');
    Sortable.create("catalog_category_products_table_tbody", { tag: "tr" });
});
