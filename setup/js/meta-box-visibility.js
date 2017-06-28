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
            pagePortfolio();


            /**
             * Live adjustment of the meta box visibility
            */
            $('#page_template').live('change', function(){
                pagePortfolio();
            }); 

            //show&hide metaboxes on the portfolio page
            function pagePortfolio() {
                if($('#page_template').val() == 'templates/page_portfolio.php') {
                    // show the meta box
                    $('#postimagediv').show();
                } else {
                    // hide your meta box
                    $('#postimagediv').hide();
                }
            }                
        });    