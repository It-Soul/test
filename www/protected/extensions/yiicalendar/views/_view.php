
<?php
    $text = CHtml::encode($data->date->format('j'));

    if(!is_null($data->link))
    {
        if(is_array($data->link))
        {
            $htmlOptions = $data->link;
            $htmlOptions['href'] = CHtml::normalizeUrl($htmlOptions['href']);

            $link = CHtml::link($text, '', $htmlOptions);
        }
        else $link = CHtml::link($text, $data->link);
    }
    else $link = $text;
?>

<?php echo $link; ?>
