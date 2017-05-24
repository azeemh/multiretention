<?php
// TAB size: 4
// Syntax to pass arguments from CLI (command line): php /path/to/wwwpublic/path/to/script.php arg1 arg2 arg 3
// Syntax to pass arguments from http: http://yourdomain.com/path/to/script.php?argument1=arg1&argument2=arg2&argument3=arg3

/* used to pass arguments via commandline or http but not with include.
if (PHP_SAPI === 'cli') {
    $argument1 = $argv[1];
    $argument2 = $argv[2];
    $argument3 = $argv[3];
    $argument4 = $argv[4];
    $argument5 = $argv[5];
} else {
    $argument1 = $_GET['argument1'];
    $argument2 = $_GET['argument2'];
    $argument3 = $_GET['argument3'];
    $argument4 = $_GET['argument4'];
    $argument5 = $_GET['argument5'];
}
*/

$startDate = $argument1; // must be in mm/dd/yyyy format
$endDate   = $argument2; // must be in mm/dd/yyyy format
$productId = $argument3;
$loginId   = $argument4;
$password  = $argument5;

$opts            = array(
    'http' => array(
        'header' => "User-Agent:MyAgent/1.0\r\n"
    )
);
$context         = stream_context_create($opts);
$url             = "https://api.konnektive.com/reports/retention/?loginId=$loginId&password=$password&startDate=$startDate&endDate=$endDate&reportType=source&include=BySubAff&productId=$productId";
$json            = file_get_contents($url, false, $context);
$serverresponse  = json_decode($json);
$message         = $serverresponse->message;
$mssgarraylength = count($serverresponse);
$sourcecount     = ($mssgarraylength - 1);
//echo "$sourcecount\n";

foreach ((array)$message as $messagepayload) {
    $sourceId             = $messagepayload->sourceId;
    $sourceName           = $messagepayload->sourceName;
    $orders               = $messagepayload->orders;
    $grossTotal           = $messagepayload->grossTotal;
    $netTotal             = $messagepayload->netTotal;
    $expensesTotal        = $messagepayload->expensesTotal;
    $lifeTimeValue        = $messagepayload->lifeTimeValue;
    $lifeTimeValuePerCust = $messagepayload->lifeTimeValuePerCust;
    $currencySymbol       = $messagepayload->currencySymbol;
    $cyclesarray          = $messagepayload->cycles; // this is an array of cycles
    


    if ($sourceName == 'Total') {
        echo '
    <tr class="collapsible total heading">
            <td colspan="3">'."<b>TOTALS FOR<br/>$OfferName:$loginId"."<br/>Product ID:$productId</b>";
    } else {
    echo '
    <tr class="collapsible offer heading">
            <td colspan="3">'."<b>$sourceName</b></td>";
    }

    echo "
            <td>$orders</td>
            <td>$currencySymbol$grossTotal</td>
            <td>$currencySymbol$netTotal</td>
            <td>$currencySymbol$expensesTotal</td>
            <td>$currencySymbol$lifeTimeValue</td>
            <td>$currencySymbol$lifeTimeValuePerCust</td>
            <td> <!--sum(all approvals)--> </td>
            <td> <!--sum(all declines)--> </td>
            <td> <!--avg (all approval rates)--> </td>
            <td> <!--avg (cpa?)--> </td>
            <td> <!--sum(all full refunds)--> </td>
            <td> <!--sum(all partial refunds)--> </td>
            <td> <!--sum(cancels)--> </td>
            <td> <!--sum(chargebacks)--> </td>
            <td> -- </td>
            <td> -- </td>
            <td> -- </td>
            <td> <!--sum(pending)--> </td>
            <td> <!--avg(retention%)--> </td>
            <td> <!--sum(retention totals)--> </td>
            <td> -- </td>
            <td> -- </td>
            <td> -- </td>
            <td> -- </td>
            <td> -- </td>
            <td> -- </td>
            <td> -- </td>
            <td> -- </td>
        </tr>
    ";

    //echo "<br/>\n<h3>$sourceName || Orders: $orders | Gross: $currencySymbol$grossTotal | Net: $currencySymbol$netTotal | Expenses: $currencySymbol$expensesTotal | LTV: $currencySymbol$lifeTimeValue | LTV/Customer: $currencySymbol$lifeTimeValuePerCust | Number of Billing Cycles: " . count($cyclesarray) . "</h3>";
    for ($z = 0; $z <= (count($cyclesarray) - 1); $z++) {
        $cycleNumber                      = $cyclesarray[$z]->cycleNumber;
        $approved                         = $cyclesarray[$z]->approved;
        $declines                         = $cyclesarray[$z]->declines;
        $approvalRate                     = $cyclesarray[$z]->approvalRate;
        $cpa                              = $cyclesarray[$z]->cpa;
        $fullRefunds                      = $cyclesarray[$z]->fullRefunds;
        $partialRefunds                   = $cyclesarray[$z]->partialRefunds;
        $cancels                          = $cyclesarray[$z]->cancels;
        $chargebacks                      = $cyclesarray[$z]->chargebacks;
        $chargebackRate                   = $cyclesarray[$z]->chargebackRate;
        $chargebackRev                    = $cyclesarray[$z]->chargebackRev;
        $recycles                         = $cyclesarray[$z]->recycles;
        $pending                          = $cyclesarray[$z]->pending;
        $retention                        = $cyclesarray[$z]->retention;
        $retTotal                         = $cyclesarray[$z]->retTotal;
        $gross                            = $cyclesarray[$z]->gross;
        $expenses                         = $cyclesarray[$z]->expenses;
        $comission                        = $cyclesarray[$z]->comission;
        $net                              = $cyclesarray[$z]->net;
        $transactionFee                   = $cyclesarray[$z]->transactionFee;
        $discountRateFee                  = $cyclesarray[$z]->discountRateFee;
        $shippingCosts                    = $cyclesarray[$z]->shippingCosts;
        $productCosts                     = $cyclesarray[$z]->productCosts;
        $hardDecline                      = $cyclesarray[$z]->hardDecline;
        $softDecline                      = $cyclesarray[$z]->softDecline;
        $recycleSave                      = $cyclesarray[$z]->recycleSave;
        $InitialRecycle_successes         = $cyclesarray[$z]->recycleInitial->successes;
        $InitialRecycle_softDeclines      = $cyclesarray[$z]->recycleInitial->softDeclines;
        $InitialRecycle_hardDeclines      = $cyclesarray[$z]->recycleInitial->hardDeclines;
        $InitialRecycle_successRate       = $cyclesarray[$z]->recycleInitial->successRate;
        $InitialRecycle_plusRetentionRate = $cyclesarray[$z]->recycleInitial->plusRetentionRate;
        
        // POSSIBLE TO DO: ADD LOOP TO save additional arrays that may exist in later cycles -- recycle 1, recycle 2, .... recycle N, etc etc.
        // For each recycle save successes, softDeclines, hardDeclines, successRate, plusretentionRate, same as recycleInital.
        if ($sourceName == 'Total') {
        echo '
    <tr class="cycle total">
        <td colspan="3">'."<i>Cycle: $cycleNumber</i></td>";
    } else {
        echo '
    <tr class="cycle offer">
        <td colspan="3">'."<i>Cycle: $cycleNumber</i></td>";
    }

        echo "
        <td> -- </td>
        <td>$currencySymbol$gross</td>
        <td>$currencySymbol$net</td>
        <td>$currencySymbol$expenses</td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td>$declines</td>
        <td>$approvalRate</td>
        <td>$cpa</td>
        <td>$currencySymbol$fullRefunds</td>
        <td>$currencySymbol$partialRefunds</td>
        <td>$cancels</td>
        <td>$chargebacks</td>
        <td>$chargebackRate</td>
        <td>$chargebackRev</td>
        <td>$recycles</td>
        <td>$pending</td>
        <td>$retention</td>
        <td>$retTotal</td>
        <td>$currencySymbol$comission</td>
        <td>$currencySymbol$transactionFee</td>
        <td>$currencySymbol$discountRateFee</td>
        <td>$currencySymbol$shippingCosts</td>
        <td>$currencySymbol$productCosts</td>
        <td>$hardDecline</td>
        <td>$softDecline</td>
        <td>$recycleSave</td>
    </tr>
        \n";
        //echo "<br/>Cycle $cycleNumber\nApproved: $approved | Declines: $declines | Approval Rate: $approvalRate | CPA: $cpa | Full Refunds: $currencySymbol$fullRefunds | Partial Refunds: $currencySymbol$partialRefunds | Cancels: $cancels | Chargebacks: $chargebacks | Chargeback Rate: $chargebackRate | Chargeback Rev: $chargebackRev | Recycles: $recycles | Pending: $pending | Retention: $retention | Retention Total: $retTotal | Gross: $gross | Expenses: $expenses | Comission: $comission | Net: $net\nTransaction Fee: $transactionFee | Discount Rate Fee: $discountRateFee | Shipping Costs: $shippingCosts | Product Costs: $productCosts | Hard Decline: $hardDecline | Soft Decline: $softDecline | Recycle Save: $recycleSave | Initial Recyle -- Successes: $InitialRecycle_successes | Soft Declines: $InitialRecycle_softDeclines | Hard Declines: $InitialRecycle_hardDeclines | Success Rate: $InitialRecycle_successRate | Plus Retention Rate: $InitialRecycle_plusRetentionRate\n";
    }
    echo "\n";

    //var_dump($messagepayload);
    
    #check if the source has a breakdown by affs (and logically subaffs cuz we asked konnective for them in the report query include=BySubAff). 
    if (array_key_exists('byPublisher', $messagepayload)) {
        $breakdownbypub = $messagepayload->byPublisher;
        foreach ($breakdownbypub as $iteratorvariable) {
            $affId                     = $iteratorvariable->affId;
            $ordersbypub               = $iteratorvariable->orders;
            $grossTotalbypub           = $iteratorvariable->grossTotal;
            $netTotalbypub             = $iteratorvariable->netTotal;
            $expensesTotalbypub        = $iteratorvariable->expensesTotal;
            $lifeTimeValuebypub        = $iteratorvariable->lifeTimeValue;
            $lifeTimeValuePerCustbypub = $iteratorvariable->lifeTimeValuePerCust;
            $currencySymbolbypub       = $iteratorvariable->currencySymbol;
            $cyclesarraybypub          = $iteratorvariable->cycles; // array of cycles by publisher/affiliate
            
            echo '
    <tr class="collapsible source heading">
        <td colspan="3">'."$sourceName::<b>$affId</b></td>
        <td>$ordersbypub</td>
        <td>$currencySymbol$grossTotalbypub</td>
        <td>$currencySymbol$netTotalbypub</td>
        <td>$currencySymbol$expensesTotalbypub</td>
        <td>$currencySymbol$lifeTimeValuebypub</td>
        <td>$currencySymbol$lifeTimeValuePerCustbypub</td>
        <td> <!--sum(all approvals by publishing source)--> </td>
        <td> <!--sum(all declines by publishing source)--> </td>
        <td> <!--avg (all approval rates by publishing source)--> </td>
        <td> <!--avg (cpa? by publishing source)--> </td>
        <td> <!--sum(all full refunds) by publishing source--> </td>
        <td> <!--sum(all partial refunds) by publishing source--> </td>
        <td> <!--sum(cancels) by publishing source--> </td>
        <td> <!--sum(chargebacks) by publishing source--> </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> <!--sum(pending) by publishing source--> </td>
        <td> <!--avg(retention%) by publishing source--> </td>
        <td> <!--sum(retention totals) by publishing source--> </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
    </tr>
            ";
            //echo "<br/><h5>AFFILIATE: $affId</h5>OVERALL--Orders: $ordersbypub | Gross: $currencySymbolbypub$grossTotalbypub | Net: $currencySymbolbypub$netTotalbypub | Expenses: $currencySymbolbypub$expensesTotalbypub | LTV: $currencySymbolbypub$lifeTimeValuebypub | LTV/Customer: $lifeTimeValuePerCustbypub | Number of Billing Cycles: " . count($cyclesarraybypub) . "\n";
            
            for ($w = 0; $w <= (count($cyclesarraybypub) - 1); $w++) {
                $cycleNumberbypub                      = $cyclesarraybypub[$w]->cycleNumber;
                $approvedbypub                         = $cyclesarraybypub[$w]->approved;
                $declinesbypub                         = $cyclesarraybypub[$w]->declines;
                $approvalRatebypub                     = $cyclesarraybypub[$w]->approvalRate;
                $cpabypub                              = $cyclesarraybypub[$w]->cpa;
                $fullRefundsbypub                      = $cyclesarraybypub[$w]->fullRefunds;
                $partialRefundsbypub                   = $cyclesarraybypub[$w]->partialRefunds;
                $cancelsbypub                          = $cyclesarraybypub[$w]->cancels;
                $chargebacksbypub                      = $cyclesarraybypub[$w]->chargebacks;
                $chargebackRatebypub                   = $cyclesarraybypub[$w]->chargebackRate;
                $chargebackRevbypub                    = $cyclesarraybypub[$w]->chargebackRev;
                $recyclesbypub                         = $cyclesarraybypub[$w]->recycles;
                $pendingbypub                          = $cyclesarraybypub[$w]->pending;
                $retentionbypub                        = $cyclesarraybypub[$w]->retention;
                $retTotalbypub                         = $cyclesarraybypub[$w]->retTotal;
                $grossbypub                            = $cyclesarraybypub[$w]->gross;
                $expensesbypub                         = $cyclesarraybypub[$w]->expenses;
                $comissionbypub                        = $cyclesarraybypub[$w]->comission;
                $netbypub                              = $cyclesarraybypub[$w]->net;
                $transactionFeebypub                   = $cyclesarraybypub[$w]->transactionFee;
                $discountRateFeebypub                  = $cyclesarraybypub[$w]->discountRateFee;
                $shippingCostsbypub                    = $cyclesarraybypub[$w]->shippingCosts;
                $productCostsbypub                     = $cyclesarraybypub[$w]->productCosts;
                $hardDeclinebypub                      = $cyclesarraybypub[$w]->hardDecline;
                $softDeclinebypub                      = $cyclesarraybypub[$w]->softDecline;
                $recycleSavebypub                      = $cyclesarraybypub[$w]->recycleSave;
                $InitialRecycle_successesbypub         = $cyclesarraybypub[$w]->recycleInitial->successes;
                $InitialRecycle_softDeclinesbypub      = $cyclesarraybypub[$w]->recycleInitial->softDeclines;
                $InitialRecycle_hardDeclinesbypub      = $cyclesarraybypub[$w]->recycleInitial->hardDeclines;
                $InitialRecycle_successRatebypub       = $cyclesarraybypub[$w]->recycleInitial->successRate;
                $InitialRecycle_plusRetentionRatebypub = $cyclesarraybypub[$w]->recycleInitial->plusRetentionRate;
                
                echo '
    <tr class="cycle source">
        <td colspan="3">'."<i>Cycle: $cycleNumberbypub</i></td>
        <td> -- </td>
        <td>$currencySymbol$grossbypub</td>
        <td>$currencySymbol$netbypub</td>
        <td>$currencySymbol$expensesbypub</td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td>$declinesbypub</td>
        <td>$approvalRatebypub</td>
        <td>$cpabypub</td>
        <td>$currencySymbol$fullRefundsbypub</td>
        <td>$currencySymbol$partialRefundsbypub</td>
        <td>$cancelsbypub</td>
        <td>$chargebacksbypub</td>
        <td>$chargebackRatebypub</td>
        <td>$chargebackRevbypub</td>
        <td>$recyclesbypub</td>
        <td>$pendingbypub</td>
        <td>$retentionbypub</td>
        <td>$retTotalbypub</td>
        <td>$currencySymbol$comissionbypub</td>
        <td>$currencySymbol$transactionFeebypub</td>
        <td>$currencySymbol$discountRateFeebypub</td>
        <td>$currencySymbol$shippingCostsbypub</td>
        <td>$currencySymbol$productCostsbypub</td>
        <td>$hardDeclinebypub</td>
        <td>$softDeclinebypub</td>
        <td>$recycleSavebypub</td>
    </tr>
                ";

                //echo "Cycle $cycleNumberbypub \nApproved: $approvedbypub | Declines: $declinesbypub | Approval Rate: $approvalRatebypub | CPA: $cpabypub | Full Refunds: $currencySymbol$fullRefundsbypub | Partial Refunds: $currencySymbol$partialRefundsbypub | Cancels: $cancelsbypub | Chargebacks: $chargebacksbypub | Chargeback Rate: $chargebackRatebypub | Chargeback Rev: $chargebackRevbypub | Recycles: $recyclesbypub | Pending: $pendingbypub | Retention: $retentionbypub | Retention Total: $retTotalbypub | Gross: $grossbypub | Expenses: $expensesbypub | Comission: $comissionbypub | Net: $netbypub\nTransaction Fee: $transactionFeebypub | Discount Rate Fee: $discountRateFeebypub | Shipping Costs: $shippingCostsbypub | Product Costs: $productCostsbypub | Hard Decline: $hardDeclinebypub | Soft Decline: $softDeclinebypub | Recycle Save: $recycleSavebypub | Initial Recyle -- Successes: $InitialRecycle_successesbypub | Soft Declines: $InitialRecycle_softDeclinesbypub | Hard Declines: $InitialRecycle_hardDeclinesbypub | Success Rate: $InitialRecycle_successRatebypub | Plus Retention Rate: $InitialRecycle_plusRetentionRatebypub\n";
            }
            
            $breakdownbysub = $iteratorvariable->bySubAff;
            foreach ($breakdownbysub as $iv2) {
                $subAffId            = $iv2->subAffId;
                $ordersbysub         = $iv2->orders;
                $grossbysub          = $iv2->grossTotal;
                $netbysub            = $iv2->netTotal;
                $expensesbysub       = $iv2->expensesTotal;
                $ltvbysub            = $iv2->lifeTimeValue;
                $ltvpercustomerbysub = $iv2->lifeTimeValuePerCust;
                $currencybysub       = $iv2->currencySymbol;
                $cyclesarraybysub    = $iv2->cycles;
                
                echo '
    <tr class="subaff collapsible heading">
        <td colspan="3">'."$sourceName::$affId::<b><em>$subAffId</em></b></td>
        <td>$ordersbysub</td>
        <td>$currencySymbol$grossTotalbysub</td>
        <td>$currencySymbol$netTotalbysub</td>
        <td>$currencySymbol$expensesTotalbysub</td>
        <td>$currencySymbol$lifeTimeValuebysub</td>
        <td>$currencySymbol$lifeTimeValuePerCustbysub</td>
        <td> <!--sum(all approvals by subaff)--> </td>
        <td> <!--sum(all declines by subaff)--> </td>
        <td> <!--avg (all approval rates by subaff)--> </td>
        <td> <!--avg (cpa? by subaff)--> </td>
        <td> <!--sum(all full refunds) by subaff--> </td>
        <td> <!--sum(all partial refunds) by subaff--> </td>
        <td> <!--sum(cancels) by subaff--> </td>
        <td> <!--sum(chargebacks) by subaff--> </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> <!--sum(pending) by subaff--> </td>
        <td> <!--avg(retention%) by subaff--> </td>
        <td> <!--sum(retention totals) by subaff--> </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
    </tr>
                ";

                //echo "\n%%%%%%%%%%%%%| Sub Aff ID: $subAffId |\nOrders: $ordersbysub | Gross: $currencybysub$grossbysub | Net: $currencybysub$netbysub | Expenses: $currencybysub$expensesbysub | LTV: $currencybysub$ltvbysub | LTV/Customer: $currencybysub$ltvpercustomerbysub | Number of Billing Cycles: " . count($cyclesarraybysub) . "\n";
                
                for ($q = 0; $q <= (count($cyclesarraybysub) - 1); $q++) {
                    $cycleNumberbysub                      = $cyclesarraybysub[$q]->cycleNumber;
                    $approvedbysub                         = $cyclesarraybysub[$q]->approved;
                    $declinesbysub                         = $cyclesarraybysub[$q]->declines;
                    $approvalRatebysub                     = $cyclesarraybysub[$q]->approvalRate;
                    $cpabysub                              = $cyclesarraybysub[$q]->cpa;
                    $fullRefundsbysub                      = $cyclesarraybysub[$q]->fullRefunds;
                    $partialRefundsbysub                   = $cyclesarraybysub[$q]->partialRefunds;
                    $cancelsbysub                          = $cyclesarraybysub[$q]->cancels;
                    $chargebacksbysub                      = $cyclesarraybysub[$q]->chargebacks;
                    $chargebackRatebysub                   = $cyclesarraybysub[$q]->chargebackRate;
                    $chargebackRevbysub                    = $cyclesarraybysub[$q]->chargebackRev;
                    $recyclesbysub                         = $cyclesarraybysub[$q]->recycles;
                    $pendingbysub                          = $cyclesarraybysub[$q]->pending;
                    $retentionbysub                        = $cyclesarraybysub[$q]->retention;
                    $retTotalbysub                         = $cyclesarraybysub[$q]->retTotal;
                    $grossbysub                            = $cyclesarraybysub[$q]->gross;
                    $expensesbysub                         = $cyclesarraybysub[$q]->expenses;
                    $comissionbysub                        = $cyclesarraybysub[$q]->comission;
                    $netbysub                              = $cyclesarraybysub[$q]->net;
                    $transactionFeebysub                   = $cyclesarraybysub[$q]->transactionFee;
                    $discountRateFeebysub                  = $cyclesarraybysub[$q]->discountRateFee;
                    $shippingCostsbysub                    = $cyclesarraybysub[$q]->shippingCosts;
                    $productCostsbysub                     = $cyclesarraybysub[$q]->productCosts;
                    $hardDeclinebysub                      = $cyclesarraybysub[$q]->hardDecline;
                    $softDeclinebysub                      = $cyclesarraybysub[$q]->softDecline;
                    $recycleSavebysub                      = $cyclesarraybysub[$q]->recycleSave;
                    $InitialRecycle_successesbysub         = $cyclesarraybysub[$q]->recycleInitial->successes;
                    $InitialRecycle_softDeclinesbysub      = $cyclesarraybysub[$q]->recycleInitial->softDeclines;
                    $InitialRecycle_hardDeclinesbysub      = $cyclesarraybysub[$q]->recycleInitial->hardDeclines;
                    $InitialRecycle_successRatebysub       = $cyclesarraybysub[$q]->recycleInitial->successRate;
                    $InitialRecycle_plusRetentionRatebysub = $cyclesarraybysub[$q]->recycleInitial->plusRetentionRate;
                    
                    echo '
    <tr class="cycle subaff">
        <td colspan="3">'."<i>Cycle: $cycleNumberbysub<i></td>
        <td> -- </td>
        <td>$currencySymbol$grossbysub</td>
        <td>$currencySymbol$netbysub</td>
        <td>$currencySymbol$expensesbysub</td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td>$declinesbysub</td>
        <td>$approvalRatebysub</td>
        <td>$cpabysub</td>
        <td>$currencySymbol$fullRefundsbysub</td>
        <td>$currencySymbol$partialRefundsbysub</td>
        <td>$cancelsbysub</td>
        <td>$chargebacksbysub</td>
        <td>$chargebackRatebysub</td>
        <td>$chargebackRevbysub</td>
        <td>$recyclesbysub</td>
        <td>$pendingbysub</td>
        <td>$retentionbysub</td>
        <td>$retTotalbysub</td>
        <td>$currencySymbol$comissionbysub</td>
        <td>$currencySymbol$transactionFeebysub</td>
        <td>$currencySymbol$discountRateFeebysub</td>
        <td>$currencySymbol$shippingCostsbysub</td>
        <td>$currencySymbol$productCostsbysub</td>
        <td>$hardDeclinebysub</td>
        <td>$softDeclinebysub</td>
        <td>$recycleSavebysub</td>
    </tr>";

                    //echo "Cycle $cycleNumberbysub \nApproved: $approvedbysub | Declines: $declinesbysub | Approval Rate: $approvalRatebysub | CPA: $cpabysub | Full Refunds: $currencySymbol$fullRefundsbysub | Partial Refunds: $currencySymbol$partialRefundsbysub | Cancels: $cancelsbysub | Chargebacks: $chargebacksbysub | Chargeback Rate: $chargebackRatebysub | Chargeback Rev: $chargebackRevbysub | Recycles: $recyclesbysub | Pending: $pendingbysub | Retention: $retentionbysub | Retention Total: $retTotalbysub | Gross: $grossbysub | Expenses: $expensesbysub | Comission: $comissionbysub | Net: $netbysub\nTransaction Fee: $transactionFeebysub | Discount Rate Fee: $discountRateFeebysub | Shipping Costs: $shippingCostsbysub | Product Costs: $productCostsbysub | Hard Decline: $hardDeclinebysub | Soft Decline: $softDeclinebysub | Recycle Save: $recycleSavebysub | Initial Recyle -- Successes: $InitialRecycle_successesbysub | Soft Declines: $InitialRecycle_softDeclinesbysub | Hard Declines: $InitialRecycle_hardDeclinesbysub | Success Rate: $InitialRecycle_successRatebysub | Plus Retention Rate: $InitialRecycle_plusRetentionRatebysub\n";
                }
            }
        }
        echo "\n";
        
    } else {
        //echo "POST to RAILS server for fields without subaff breakdown\n\n";
    }
}

$statsarray = array("$currentstepvalue" => "Product Id $productId", "Orders" => "$orders", "Gross" => "$currencySymbol$grossTotal", "Net" => "$currencySymbol$netTotal", "Expenses" => "$currencySymbol$expensesTotal", "Last Cycle Retention" => "$retention", "Last Cycle Retention Total" => "$retTotal");

foreach($statsarray as $key => $value) {
    echo '
        <div class="col-1-7">
            <div class="module">
                <p>'."$key: $value".'<p>
            </div>
        </div>
';
}
echo '</div>';
echo "<br/>\n";

?>