<!-- Sublime Text Settings: Tab Space 4 - PHP -->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Retention Report AZ</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="//code.jquery.com/tableexport.css" rel="stylesheet">
  <script src="//code.jquery.com/jquery.min.js"></script>
  <script src="//code.jquery.com/FileSaver.min.js"></script>
  <script src="//code.jquery.com/tableexport.js"></script>
  <script src="//code.jquery.com/Blob.min.js"></script>
  <script src="//code.jquery.com/xls.core.min.js"></script>


  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }

  } );
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
      var maxField = 100; //Input fields increment limitation
      var addButton = $('.add_button'); //Add button selector
      var wrapper = $('.field_wrapper'); //Input field wrapper
      var fieldHTML =  {row :function(f){
              return '<div><label>Offer Name</label><input type="text" name="field_name[1][]" value=""/><label>API User Name</label><input type="text" name="field_name[1][]" value=""/><label>API Password</label><input type="text" name="field_name[1][]" value=""/><label>Product ID for Step 1</label><input type="text" name="field_name[1][]" value=""/><label>Product ID for Step 2</label><input type="text" name="field_name[1][]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove Field</a></div>'; //New input field html 
          }};

      var x = 1; //Initial field counter is 1
      $(addButton).click(function(){ //Once add button is clicked
          if(x < maxField){ //Check maximum number of input fields
              x++; //Increment field counter
              $(wrapper).append(fieldHTML.row(x)); // Add field html
          }
      });
      $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
          e.preventDefault();
          $(this).parent('div').remove(); //Remove field html
          x--; //Decrement field counter
      });

      //makes table rows collapse/expand using the html class collapsible up to the next collapisble element
      $('.collapsible').click(function() {
        if ($(this).hasClass("collapsed")) {
          $(this).nextUntil('tr.collapsible')
            .find('td')
            .parent()
            .find('td > div')
            .slideDown("fast", function() {
              var $set = $(this);
              $set.replaceWith($set.contents());
            });
          $(this).removeClass("collapsed");
        } else {
          $(this).nextUntil('tr.collapsible')
            .find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp("fast");
          $(this).addClass("collapsed");
        }
      });

      $('.rnested').click(function() {
        if ($(this).hasClass("collapsed")) {
          $(this).nextUntil('tr.rnested')
            .find('td')
            .parent()
            .find('td > div')
            .slideDown("fast", function() {
              var $set = $(this);
              $set.replaceWith($set.contents());
            });
          $(this).removeClass("collapsed");
        } else {
          $(this).nextUntil('tr.rnested')
            .find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp("fast");
          $(this).addClass("collapsed");
        }
      });

      $('.subnested').click(function() {
        if ($(this).hasClass("collapsed")) {
          $(this).nextUntil('tr.subnested')
            .find('td')
            .parent()
            .find('td > div')
            .slideDown("fast", function() {
              var $set = $(this);
              $set.replaceWith($set.contents());
            });
          $(this).removeClass("collapsed");
        } else {
          $(this).nextUntil('tr.subnested')
            .find('td')
            .wrapInner('<div style="display: block;" />')
            .parent()
            .find('td > div')
            .slideUp("fast");
          $(this).addClass("collapsed");
        }
      });

  });
  </script>

  <style type="text/css">
  html {
    font-family: helvetica;
    background-color: white;
    font-size: 12px;
  }

  .collapsible {
    font-family: sans-serif;
    cursor: pointer;
  }

  .heading:hover {
    background-color: #EFF0F0;
  }

  .offer {
    color: #DF0170;
  }

  .source {
    color: orange;
  }

  .subaff {
    color: turquoise;
  }
  .total {
    color: limegreen;
  }

  td {

    font-size: 12px;
  }

  .stepvalue {
    font-size: 14px;
  }

  * {
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
  }

  .grid {
    background: white;
    margin: none;
  }
  .grid:after {
    /* Or @extend clearfix */
    content: "";
    display: table;
    clear: both;
  }

  [class*='col-'] {
    float: left;
    padding-right: 10px;
  }
  .grid [class*='col-']:last-of-type {
    padding-right: 0;
  }

  .col-2-3 {
    width: 66.66%;
  }

  .col-1-3 {
    width: 33.33%;
  }

  .col-1-2 {
    width: 50%;
  }

  .col-1-4 {
    width: 25%;
  }

  .col-1-7 {
    width: 14.2%;
  }

  .module {
    padding: 10px;
    background: #eee;
  }

  body {
    padding: none;
  }

  h1 {
    color: black;
    font-size: 12px;
    padding-top: 5px;
    padding-bottom: none;
  }
  h1 em {
    color: #666;
    font-size: 16px;
  }

  </style>
</head>
<body>
 
<h1>Multi API User Konnective Retention Report</h1>

<section>
<form action="" method="post">

<h4>Date Range</h4>
<label for="from">From</label>
<input type="text" id="from" name="from">
<label for="to">to</label>
<input type="text" id="to" name="to">

<h3>How to Use:</h3>
<p>Returns a Retention Report across multiple API users given a product Id.<br/>
Enter a username, password, and product id for each offer you want to track and you will see a collapsible breakdown per publishing  affiliate, per sub-affiliate id. Each Product will have it's own Total Row. <!--Furthermore it's built with future extensibility in mind, allowing for HTML table functions by viewing the source, allowing calculations per set of offers etc on a dynamically created table, - or more simply by summing all the values in a column etc. CSV and Excel export to come.--></p> 

<div class="field_wrapper">
    <div>
        <label>Offer Name</label><input type="text" name="field_name[1][]" value=""/><label>API User Name</label><input type="text" name="field_name[1][]" value=""/><label>API Password</label><input type="text" name="field_name[1][]" value=""/><label>Product ID for Step 1</label><input type="text" name="field_name[1][]" value=""/><label>Product ID for Step 2</label><input type="text" name="field_name[1][]" value=""/>
        <a href="javascript:void(0);" class="add_button" title="Add field">+</a>
    </div>
</div>
<input type="submit" name="submit" value="SUBMIT"/>
</form>
</section>



<?php

$argument1 = $_POST['from'];
$argument2 = $_POST['to'];

echo '
<table>
    <tr>
        <td colspan="3"><h4>See Retention Per</h4></td>
        <td><h4>Orders:</h4></td>
        <td><h4>Gross:</h4></td>
        <td><h4>Net:</h4></td>
        <td><h4>Expenses:</h4></td>
        <td><h4>LTV:</h4></td>
        <td><h4>LTV/Customer:</h4></td>
        <td><h4>Approved:</h4></td>
        <td><h4>Declines:</h4></td>
        <td><h4>Approval Rate:</h4></td>
        <td><h4>CPA:</h4></td>
        <td><h4>Full Refunds:</h4></td>
        <td><h4>Partial Refunds:</h4></td>
        <td><h4>Cancels:</h4></td>
        <td><h4>Chargebacks:</h4></td>
        <td><h4>Chargeback Rate:</h4></td>
        <td><h4>Chargeback Rev:</h4></td>
        <td><h4>Recycles:</h4></td>
        <td><h4>Pending:</h4></td>
        <td><h4>Retention:</h4></td>
        <td><h4>Retention Total:</h4></td>
        <td><h6>Comissions:</h6></td>
        <td><h6>Transaction Fees:</h6></td>
        <td><h6>Discount Rate Fees:</h6></td>
        <td><h6>Shipping Costs:</h6></td>
        <td><h6>Product Costs:</h6></td>
        <td><h6>Hard Decline:</h6></td>
        <td><h6>Soft Decline:</h6></td>
        <td><h6>Recycle Saves:</h6></td>
    </tr>

';
if ($_POST) {
    $field_values_array = array_filter($_POST['field_name']);
    if ($field_values_array) {
        foreach ($field_values_array as $value) {
            $OfferName  = $value[0]; // saves 1st input as offer name
            $offerlogin = $value[1]; // saves 2nd input as loginid
            $offerpw    = $value[2]; // saves 3rd input as password
            $offerstep1 = $value[3]; // saves 4th input as product id for step 1
            $offerstep2 = $value[4]; // saves 5th input as product id for step 2
            $osteps     = array(
                $offerstep1,
                $offerstep2
            );

            echo '
<div class="grid grid-pad">
<h2>'."$OfferName".'</h2>
';
            foreach ($osteps as $val) {
                $argument3 = $val;
                $argument4 = $offerlogin;
                $argument5 = $offerpw;

                if ($val==$offerstep1){
                    $currentstepvalue = "Step 1";
                    echo '<tr class="stepvalue heading"><td colspan="31"><h1>'."$OfferName step 1 product Id: $offerstep1</h1></td></tr>\n";
                } else {
                    $currentstepvalue = "Step 2";
                    echo '<tr class="stepvalue heading"><td colspan="31"><h1>'."$OfferName step 2 product Id: $offerstep2</h1></td></tr>\n";
                }

                require('retentionreport.php');
            }
            
            //echo '<br/>';
            //echo "loginId $argument4 and password $argument5 will be used to find retention of product Id $argument3 given start date: $argument1 and end date: $argument2\n";
            //echo "<h4>Retention From $argument1 to $argument2 for Product Id: $argument3 on API User: $argument4</h4>\n";
            
            //require('retentionreport.php');
            //echo 'run a request to retentionreport.php <br />';
        }
    }
}
echo '</table>' . "\n";
?>
</body>
</html>