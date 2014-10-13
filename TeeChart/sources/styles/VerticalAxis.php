<?php

/**
 * VerticalAxis class
 *
 * Description: Describes the possible values of Series.VertAxis method
 *
 * @author
 * @copyright (c) 1995-2008 by Steema Software SL. All Rights Reserved. <info@steema.com>
 * @version 1.0
 * @package TeeChartPHP
 * @subpackage styles
 * @link http://www.steema.com
 */

class VerticalAxis
{
   /**
   * Associates the series with the left axis.
   */
   public static $LEFT = 0;
   /**
   * Associates the series with the right axis.
   */
   public static $RIGHT = 1;
   /**
   * Associates the series with both the left and right axis.
   */
   public static $BOTH = 2;
   /**
   * Associates the series with a custom axis.
   */
   public static $CUSTOM = 3;

   public function VerticalAxis()     {}

   public function fromInt($value)
   {
      switch($value)
      {
         case 0:
            return self::$LEFT;
         case 1:
            return self::$RIGHT;
         case 2:
            return self::$BOTH;
         default:
            return self::$CUSTOM;
      }
   }
}
?>