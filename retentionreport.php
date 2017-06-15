<?php
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
    <tr class="total heading ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td >'."<b>TOTALS FOR<br/>$OfferName:$loginId"."<br/>Product ID:$productId</b>";
    } else {
    echo '
    <tr class="offer heading ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td>'."<b>$sourceName</b></td>";
    }
    echo "
        <td> -- </td>
        <td> -- </td>
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
    </tr>";
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
    <tr class="cycle total ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td>'."$sourceName <i>Cycle: $cycleNumber</i></td>";
    } else {
        echo '
    <tr class="cycle offer ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td>'."$sourceName <i>Cycle: $cycleNumber</i></td>";
    }

        echo "
        <td> -- </td>
        <td> -- </td>
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
    </tr>";
    }
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
    <tr class="source heading ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td>'."$sourceName::<b>$affId</b></td>
        <td>$affId</td>
        <td> -- </td>
        <td>$ordersbypub</td>
        <td>$currencySymbolbypub$grossTotalbypub</td>
        <td>$currencySymbolbypub$netTotalbypub</td>
        <td>$currencySymbolbypub$expensesTotalbypub</td>
        <td>$currencySymbolbypub$lifeTimeValuebypub</td>
        <td>$currencySymbolbypub$lifeTimeValuePerCustbypub</td>
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
    </tr>";
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
    <tr class="cycle source ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td>'."$sourceName::<b>$affId</b> <i>Cycle: $cycleNumberbypub</i></td>
        <td>$affId</td>
        <td> -- </td>
        <td> -- </td>
        <td>$currencySymbolbypub$grossbypub</td>
        <td>$currencySymbolbypub$netbypub</td>
        <td>$currencySymbolbypub$expensesbypub</td>
        <td> -- </td>
        <td> -- </td>
        <td> -- </td>
        <td>$declinesbypub</td>
        <td>$approvalRatebypub</td>
        <td>$cpabypub</td>
        <td>$currencySymbolbypub$fullRefundsbypub</td>
        <td>$currencySymbolbypub$partialRefundsbypub</td>
        <td>$cancelsbypub</td>
        <td>$chargebacksbypub</td>
        <td>$chargebackRatebypub</td>
        <td>$chargebackRevbypub</td>
        <td>$recyclesbypub</td>
        <td>$pendingbypub</td>
        <td>$retentionbypub</td>
        <td>$retTotalbypub</td>
        <td>$currencySymbolbypub$comissionbypub</td>
        <td>$currencySymbolbypub$transactionFeebypub</td>
        <td>$currencySymbolbypub$discountRateFeebypub</td>
        <td>$currencySymbolbypub$shippingCostsbypub</td>
        <td>$currencySymbolbypub$productCostsbypub</td>
        <td>$hardDeclinebypub</td>
        <td>$softDeclinebypub</td>
        <td>$recycleSavebypub</td>
    </tr>";
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
    <tr class="subaff heading ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td>'."$sourceName::$affId::<b><em>$subAffId</em></b></td>
        <td>$affId</td>
        <td>$subAffId</td>
        <td>$ordersbysub</td>
        <td>$currencybysub$grossbysub</td>
        <td>$currencybysub$netbysub</td>
        <td>$currencybysub$expensesbysub</td>
        <td>$currencybysub$ltvbysub</td>
        <td>$currencybysub$ltvpercustomerbysub</td>
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
    </tr>";
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
    <tr class="cycle subaff ihover">
        '."<td>$OfferName</td>
        <td>$currentstepvalue</td>".'
        <td>'."<i>$sourceName::$affId::<b><em>$subAffId</em></b> Cycle: $cycleNumberbysub<i></td>
        <td>$affId</td>
        <td>$subAffId</td>
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
                }
            }
        }
    } else {
    }
}
$statsarray = array("$currentstepvalue" => "Product Id $productId", "Orders" => "$orders", "Gross" => "$currencySymbol$grossTotal", "Net" => "$currencySymbol$netTotal", "Expenses" => "$currencySymbol$expensesTotal", "Last Cycle Retention" => "$retention", "Last Cycle Retention Total" => "$retTotal");
foreach ($statsarray as $akey => $avalue) {
    echo '<div class="module col-1-7">'."$akey: $avalue</div>";
}
echo '</div>';
?>