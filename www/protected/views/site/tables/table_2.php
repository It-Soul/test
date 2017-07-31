<?php if (!empty($kat_oe)) { ?>
    <table id="replacementgrid" class="dgrid" width="100%">
        <?php foreach ($kat_oe as $item) { ?>
            <tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">
                <td class="code"><?php echo $item['oeindeks'] ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>