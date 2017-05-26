<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Retention Report AZ</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
              return '<div><label>Offer Name</label><input type="text" name="field_name['+f+'][]" value=""/><label>API User Name</label><input type="text" name="field_name['+f+'][]" value=""/><label>API Password</label><input type="text" name="field_name['+f+'][]" value=""/><label>Product ID for Step 1</label><input type="text" name="field_name['+f+'][]" value=""/><label>Product ID for Step 2</label><input type="text" name="field_name['+f+'][]" value=""/><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove Field</a></div>'; //New input field html 
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
  });
  </script>
  <style type="text/css">
  html {
    font-family: helvetica;
    background-color: white;
    font-size: 12px;
  }
  .ihover:hover {
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
  td, th {
    text-align: center;
    font-size: 11px;
  }

  .fixed_headers {
    width: @table_width;
    table-layout: fixed;
    border-collapse: collapse;
    
    th { text-decoration: underline; }
    th, td {
      padding: 5px;
      text-align: left;
    }
    
    td:nth-child(1), th:nth-child(1) { min-width: @column_one_width; }
    td:nth-child(2), th:nth-child(2) { min-width: @column_two_width; }
    td:nth-child(3), th:nth-child(3) { width: @column_three_width; }

    thead {
      background-color: @header_background_color;
      color: @header_text_color;
      tr {
        display: block;
        position: relative;
      }
    }
    tbody {
      display: block;
      overflow: auto;
      width: 100%;
      height: @table_body_height;
      tr:nth-child(even) {
        background-color: @alternate_row_background_color;
      }
    }
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
    background: whitesmoke;
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
  h5 {
    text-align: center;
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
Enter a username, password, and product id for each offer you want to track and you will see a breakdown per publishing  affiliate, per sub-affiliate id. Each Product will have it's own Total Row. <!--Furthermore it's built with future extensibility in mind, allowing for HTML table functions by viewing the source, allowing calculations per set of offers etc on a dynamically created table, - or more simply by summing all the values in a column etc. CSV and Excel export to come.--></p> 
<div class="field_wrapper">
    <div>
        <label>Offer Name</label><input type="text" name="field_name[1][]" value=""/><label>API User Name</label><input type="text" name="field_name[1][]" value=""/><label>API Password</label><input type="text" name="field_name[1][]" value=""/><label>Product ID for Step 1</label><input type="text" name="field_name[1][]" value=""/><label>Product ID for Step 2</label><input type="text" name="field_name[1][]" value=""/>
        <a href="javascript:void(0);" class="add_button" title="Add field">+</a>
    </div>
</div>
<input type="submit" name="submit" value="SUBMIT"/>
</form>
</section>
<section>
<?php
$from = $_POST['from'];
$to = $_POST['to'];
echo '
<table class="sortable">
<thead class="fixed_headers">
    <tr>
        <th><h5>Offer</h5></th>
        <th><h5>Step:Value</h5></th>
        <th colspan="3"><h5>Source</h5></th>
        <th><h5>Affiliate</h5></th>
        <th><h5>Sub-Affiliate</h5></th>
        <th><h5>Orders:</h5></th>
        <th><h5>Gross:</h5></th>
        <th><h5>Net:</h5></th>
        <th><h5>Expenses:</h5></th>
        <th><h5>LTV:</h5></th>
        <th><h5>LTV/Customer:</h5></th>
        <th><h5>Approved:</h5></th>
        <th><h5>Declines:</h5></th>
        <th><h5>Approval Rate:</h5></th>
        <th><h5>CPA:</h5></th>
        <th><h5>Full Refunds:</h5></th>
        <th><h5>Partial Refunds:</h5></th>
        <th><h5>Cancels:</h5></th>
        <th><h5>Chargebacks:</h5></th>
        <th><h5>Chargeback Rate:</h5></th>
        <th><h5>Chargeback Rev:</h5></th>
        <th><h5>Recycles:</h5></th>
        <th><h5>Pending:</h5></th>
        <th><h5>Retention:</h5></th>
        <th><h5>Retention Total:</h5></th>
        <th><h5>Comissions:</h5></th>
        <th><h5>Transaction Fees:</h5></th>
        <th><h5>Discount Rate Fees:</h5></th>
        <th><h5>Shipping Costs:</h5></th>
        <th><h5>Product Costs:</h5></th>
        <th><h5>Hard Decline:</h5></th>
        <th><h5>Soft Decline:</h5></th>
        <th><h5>Recycle Saves:</h5></th>
    </tr>
</thead>
<tbody>'."\n";
if ($_POST) {
    $field_values_array = array_filter($_POST['field_name']);
    if ($field_values_array) {
        foreach ($field_values_array as $value){
            $OfferName  = $value[0]; // saves 1st input as offer name
            $offerlogin = $value[1]; // saves 2nd input as loginid
            $offerpw    = $value[2]; // saves 3rd input as password
            $offerstep1 = $value[3]; // saves 4th input as product id for step 1
            $offerstep2 = $value[4]; // saves 5th input as product id for step 2
            $osteps     = array(
                $value[3],
                $value[4]
            );
            echo '<div class="grid"><h3>'."$OfferName at a glance:<h3>";
            foreach ($osteps as $val) {
                $argument1 = $from;
                $argument2 = $to;
                $argument3 = $val;
                $argument4 = $offerlogin;
                $argument5 = $offerpw;
                if ($val == $offerstep1){
                    $currentstepvalue = "Step 1";
                } else {
                    $currentstepvalue = "Step 2";
                }
                require('retentionreport.php');
            }
        }
    }
}
echo '</tbody></table>' . "\n";
?>
 <script src="sorttable.js"></script>
</section>
</body>
</html>