<?php class InterCars
{

    public static $tradingConditionsCodes = array(
        0 => 357141,
        1 => 839889,
    );

    /**
     * Get products by tow cod
     * @param $cod
     * @return array
     */
    public static function getProductsByCod($cod)
    {
        return Yii::app()->db->createCommand()
            ->selectDistinct('t.*')
            ->from('tow_prices t')
            ->leftJoin('i_sta i', 't.tow_kod=i.tow_kod')
            ->where(array('like', 't.kod_p', "%$cod%"))->andWhere('i.mag_fir=:czo OR i.mag_fir=:rze', array('czo' => 'CZO', 'rze' => 'RZE'))
            ->queryAll();
    }

    /**
     * Get product image
     * @param $cod
     * @return mixed
     */
    public static function getProductImage($cod)
    {
        return Yii::app()->db->createCommand()
            ->select('CONCAT("IC", kz.tow_kod) image_folder, CONCAT(kz.zdjnazwa, ".jpg") image_name')
            ->from('kat_zdj kz')
            ->where('kz.tow_kod=:kod', array(':kod' => $cod))
            ->queryRow();
    }

    /**
     * Get product price
     *
     * @param $cod
     * @param $siteCoefficients
     * @param $exchangeRates
     * @return float|mixed
     */
    public static function getProductPrices($cod, $siteCoefficients, $exchangeRates)
    {
        $i = 0;
        do {
            $price = Yii::app()->db->createCommand()
                ->select("get_opt_price('$cod', " . self::$tradingConditionsCodes[$i] . ", 'PLN', 0, 0) opt_cena")
                ->queryRow();
            $wholesalePrice = $price['opt_cena'];
            $i++;
        } while (!$wholesalePrice && $i <= 1);

        $price = round($wholesalePrice * $siteCoefficients->logistic * ($exchangeRates), 0);
        $adminPrice = ($price * $siteCoefficients->admin_coef) - $price;
        $curatorPrice = ($price * $siteCoefficients->curator_coef) - $price;
        $managerPrice = ($price * $siteCoefficients->manager_coef) - $price;
        $price = round($adminPrice + $curatorPrice + $managerPrice + $price, 0);

        return array(
            'price' => $price,
            'wholesalePrice' => $wholesalePrice
        );
    }

    /**
     * Get product availability on chosen affiliate
     * @param $cod
     * @param $affiliate
     * @return mixed
     */
    public static function getProductAvailability($cod, $affiliate)
    {
        return Yii::app()->db->createCommand()
            ->select('i.*')
            ->from('i_sta i')
            ->where("i.tow_kod=:kod AND i.mag_fir=:filia", array(':kod' => $cod, ':filia' => $affiliate))
            ->queryRow();
    }

    /**
     * Get list of product articles
     * @param $cod
     * @return array
     */
    public static function getProductArticles($cod)
    {
        $product_art_inf = Yii::app()->db->createCommand()
            ->select('ka.*')
            ->from('kat_artinf ka')
            ->where('ka.art=:art', array(':art' => $cod))
            ->queryAll();

        if ($product_art_inf) {
            foreach ($product_art_inf as $key => $articleInfo) {
                $product_art_inf_naz = Yii::app()->db->createCommand()
                    ->select('kn.*')
                    ->from('kat_naz kn')
                    ->where('kn.naz=:naz', array(':naz' => $articleInfo['naz']))->andWhere('kn.lang=:lang', array(':lang' => 'RU'))
                    ->queryRow();

                $product_art_inf_naz1 = Yii::app()->db->createCommand()
                    ->select('kn.*')
                    ->from('kat_naz kn')
                    ->where('kn.naz=:naz', array(':naz' => $articleInfo['naz1']))
                    ->queryRow();

                $articles[$key]['naz'] = $product_art_inf_naz['nazwa'];
                $articles[$key]['naz1'] = $product_art_inf_naz1['nazwa'];
            }
        }

        return $articles;
    }

    /**
     * Get product substitutes
     * @param $cod
     * @param $exchangeRates
     * @param $siteCoefficients
     * @return array
     */
    public static function getSubstitutes($cod, $exchangeRates, $siteCoefficients)
    {
        $substitutes = Yii::app()->db->createCommand()
            ->selectDistinct('tp.*')
            ->from('tow_tow tt')
            ->where('tt.tow_kod=:kod', array(':kod' => $cod))->andWhere('i.mag_fir=:czo OR i.mag_fir=:rze', array('czo' => 'CZO', 'rze' => 'RZE'))
            ->leftJoin('tow_prices tp', 'tt.tow_kod_2=tp.tow_kod')
            ->leftJoin('i_sta i', 'tt.tow_kod=i.tow_kod')
            ->queryAll();

        foreach ($substitutes as $key => $substitute) {
            $substitutes[$key]['substitute_image'] = self::getProductImage($substitute['tow_kod']);
            $prodPrice = self::getProductPrice($substitute['kod_p']);
            if (Yii::app()->session['session_info'] == 1) {
                $ex_rate = $exchangeRates->zloty;
            } else {
                $ex_rate = $exchangeRates->zloty + (($exchangeRates->zloty_repair * $exchangeRates->zloty) / 100);
            };
            $price = round($prodPrice * $siteCoefficients->logistic * ($ex_rate), 0);
            $admin_price = ($price * $siteCoefficients->admin_coef) - $price;
            $curator_price = ($price * $siteCoefficients->curator_coef) - $price;
            $manager_price = ($price * $siteCoefficients->manager_coef) - $price;
            $price = round($admin_price + $curator_price + $manager_price + $price, 0);
            $substitutes[$key]['substitute_final_price'] = $price;
        }

        return $substitutes;
    }

    /**
     * Product information
     * @param $cod
     * @param $exchangeRates
     * @param $siteCoefficients
     * @return mixed
     */
    public static function getProductInfo($cod, $exchangeRates, $siteCoefficients)
    {
        $product['info'] = Yii::app()->db->createCommand()
            ->select('t.*')
            ->from('tow_prices t')
            ->where("t.kod_p=:kod", array(':kod' => $cod))
            ->queryRow();

        $product['avaliability_czo'] = self::getProductAvailability($product['info']['tow_kod'], 'CZO');
        $product['avaliability_rze'] = self::getProductAvailability($product['info']['tow_kod'], 'RZE');

        $product['image'] = self::getProductImage($product['info']['tow_kod']);

        $product['substitutes'] = self::getSubstitutes($product['info']['tow_kod'], $exchangeRates, $siteCoefficients);

        $product_art = Yii::app()->db->createCommand()
            ->select('ka.*')
            ->from('kat_art ka')
            ->where('ka.tow_kod=:kod', array(':kod' => $product['info']['tow_kod']))
            ->queryRow();
        $product['articles'] = self::getProductArticles($product_art['art']);

        $product['kat_oe'] = Yii::app()->db->createCommand()
            ->select('ko.*')
            ->from('kat_oe ko')
            ->where('ko.art=:art', array(':art' => $product_art['art']))
            ->queryAll();

        return $product;
    }
}