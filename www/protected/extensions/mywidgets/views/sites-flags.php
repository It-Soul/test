<div class="span3" style="width: 370px; height: 160px; margin: 5px 35px; float: right">
    <table class="items table table-striped table-bordered">
        <tbody>
        <tr class="odd">
            <td style="width:10px">
                <?php if ($exchangeRates->status == 0) { ?>
                    <span class="red">&nbsp;</span>
                <?php } else { ?>
                    <span class="green">&nbsp;</span>
                <?php } ?>
            </td>
            <td style="text-align:center">
                <b>PLN - <span
                            style="color: grey"><?php echo number_format($exchangeRates->finalZlotyCourse, 2, ',', '') ?></span></b>
                <b>EUR - <span
                            style="color: grey"><?php echo number_format($exchangeRates->finalEuroCourse, 2, ',', '') ?></span></b>
                <b>USD - <span
                            style="color: grey"><?php echo number_format($exchangeRates->finalUsDollarCourse, 2, ',', '') ?></span></b>
            </td>
        </tr>
        <?php foreach ($sites as $site) { ?>
            <tr class="odd">
                <td style="width:10px">
                    <?php if ($site->status == 0) { ?>
                        <span class="red">&nbsp;</span>
                    <?php } else { ?>
                        <span class="green">&nbsp;</span>
                    <?php } ?>
                </td>
                <td style="text-align:center"><?php echo $site->siteinfo->name ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>