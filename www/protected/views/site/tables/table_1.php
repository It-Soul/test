<?php if (!empty($articles)) { ?>
    <table id="replacementgrid" class="dgrid" width="100%">
        <?php foreach ($articles as $article) { ?>
            <tr class="dgriditem clickable producercode_SOLARIS producername_ quantity_zero articlestate_normal quantity_0">
                <td class="code"><?php echo $article['naz'] ?></td>
                <td class="code"><?php echo $article['naz1'] ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>