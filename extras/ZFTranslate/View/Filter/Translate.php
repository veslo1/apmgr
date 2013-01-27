<?php
/**
 * @author janburkl
 * @link http://devzone.zend.com/article/4513-Zend-Framework-and-Translation
 * <p>Filter implementation , our views will automatically translate to the proper language when we use the defined tag</p>
 * @example <i18n replacement="John,McClane">Dear Mr. %s %s,</i18n>. The replacement is optional
 */
class ZFTranslate_View_Filter_Translate implements Zend_Filter_Interface {

	/**
	 * Starting delimiter for translation snippets in view
	 */
	const I18N_DELIMITER_START = '<i18n>';

	/**
	 * Ending delimiter for translation snippets in view
	 */
	const I18N_DELIMITER_END = '</i18n>';

	/**
	 * Attribute name
	 * Value is used for replacing content with vsprintf
	 */
	const REPLACEMENT_ATTR = 'replacement';

	/**
	 * If there is more than one value to replace, delimite them with this string
	 */
	const REPLACEMENT_ATTR_DELIMITER = ',';

	/**
	 * (non-PHPdoc)
	 * @see library/Zend/Filter/Zend_Filter_Interface#filter($value)
	 */
	public function filter($value) {
		$startDelimiterLength = strlen(self::I18N_DELIMITER_START);
		$endDelimiterLength = strlen(self::I18N_DELIMITER_END);

		$translator = Zend_Registry::get('Zend_Translate');

		$delimiterStart = substr(self::I18N_DELIMITER_START, 0, -1);
		//TODO This code is *ugly* change it, I had to @ it, due to a odd issue at http://apmgr.com/role/create, the last link in the page, throws an error
		$offset = 0;
		while (($posStart = @strpos($value, $delimiterStart, $offset)) !== false) {
			$offset = $posStart + $startDelimiterLength;

			// check for an tag ending '>'
			$posTagEnd = strpos($value, '>', $offset - 1);
			$formatValues = null;
			// if '<i18n' is not followed by char '>' directly, then we obviously have attributes in our tag
			if ($posTagEnd - $posStart + 1 > $startDelimiterLength) {
				$format = substr($value, $offset, $posTagEnd - $offset);
				$matches = array();
				// check for value of 'format' attribute and explode it into $formatValues
				preg_match('/' . self::REPLACEMENT_ATTR . '="([^"]*)"/', $format, $matches);
				if (isset($matches[1])) $formatValues = explode(self::REPLACEMENT_ATTR_DELIMITER, $matches[1]);
				$offset = $posTagEnd + 1;
			}

			if (($posEnd = strpos($value, self::I18N_DELIMITER_END, $offset)) === false) {
				throw new Zx_Exception("No ending tag after position [$offset] found!");
			}
			$translate = substr($value, $offset, $posEnd - $offset);

			$translate = $translator->_($translate);
			if (is_array($formatValues)) $translate = vsprintf($translate, $formatValues);

			$offset = $posEnd + $endDelimiterLength;
			$value = substr_replace($value, $translate, $posStart, $offset - $posStart);
			$offset = $offset - $startDelimiterLength - $endDelimiterLength;
		}
		return $value;
	}
}