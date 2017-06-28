/* 
 * Change Meta Box visibility according to Page Template
 *
 * Usage:
 * - adjust $('#postimagediv') to your meta box
 * - change 'page-portfolio.php' to your template's filename
 * - remove the console.log outputs
 */

jQuery(document).ready( function($) {

    /**
     * Adjust visibility of the meta box at startup
    */
    pageAll();

    /**
     * Live adjustment of the meta box visibility
    */
    $('#page_template').live('change', function(){
        pageAll();
    }); 

    //show&hide metaboxes on certian pages
    function pageAll() {
        // hide your meta box
        //$('#postimagediv').hide();
        $('#pageparentdiv label[for=menu_order]').parents('p').eq(0).hide();
        $('#pageparentdiv input#menu_order').hide();
        $('#pageparentdiv label[for=parent_id]').parents('p').eq(0).hide();
        $('#pageparentdiv select#parent_id').hide();

        //call all the template specific ones
        if($('#page_template').val() == 'templates/page_home.php') {
            $('#postdivrich').hide();
        }
    }  

    
    


});    