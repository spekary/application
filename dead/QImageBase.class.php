<?php
	/**
	 * This file contains the QImageBase class.
	 *
	 * @package Controls
	 */

	/**
	 * @package Controls
	 *
	 * @property string $CacheFolder
	 * @property string $CacheFilename
	 * @property string $AlternateText
	 * @property string $ImageType
	 * @property integer $JpegQuality
	 */
	abstract class QImageBase extends QControl {
		///////////////////////////
		// Private Member Variables
		///////////////////////////

		// APPEARANCE
		protected $strAlternateText;
		protected $strImageType = QImageType::Png;
		protected $intJpegQuality = 100;

		// CacheFolder Location for Cached Generated Images (if applicable)
		protected $strCacheFolder = null;
		protected $strCacheFilename = null;

		// Internally Used
		protected $strCachedActualFilePath = null;
		protected $strControlClassName = 'QImageBase';
		protected $strImagickTempFilePath = '/tmp';

		//////////
		// Methods
		//////////
		public function ParsePostData() {}

		/**
		 * Validates the control. For now, just returns true (since there is nothing to validate in the control)
		 * @return bool
		 */
		public function Validate() {return true;}

		/**
		 * Constructor method
		 *
		 * @param QControl|QControlBase|QForm $objParentObject
		 * @param null|string                        $strControlId
		 *
		 * @throws Exception
		 * @throws \QCubed\Exception\Caller
		 */
		public function __construct($objParentObject, $strControlId = null) {
			if ($objParentObject)
				parent::__construct($objParentObject, $strControlId);
		}

		public function RenderAsImgSrc($blnDisplayOutput = true) {
			// Serialize and Hash Data
			$strSerialized = $this->Serialize();
			$strHash = md5($strSerialized);

			// Figure Out Image Filename
			if ($this->strCacheFilename)
				$strImageFilename = $this->strCacheFilename;
			else {
				$strImageFilename = $strHash;

				switch ($this->strImageType) {
					case QImageType::Gif:
						$strImageFilename .= '.gif';
						break;
					case QImageType::AnimatedGif:
						$strImageFilename .= '.gif';
						break;
					case QImageType::Jpeg:
						$strImageFilename .= '.jpg';
						break;
					default:
						$strImageFilename .= '.png';
						break;
				}
			}

			// Figure out IMG SRC path based on Caching prefs
			if ($this->strCacheFolder) {
				$strFilePath = sprintf('%s%s/%s',
					__DOCROOT__,
					str_replace(__VIRTUAL_DIRECTORY__, '', $this->strCacheFolder),
					$strImageFilename);

				if (!file_exists($strFilePath))
					$this->RenderImage($strFilePath);

				$strPath = sprintf('%s/%s',
					$this->strCacheFolder,
					$strImageFilename);

				// Store Cache Filepath Info
				$this->strCachedActualFilePath = $strFilePath;
			} else {
				$strPath = sprintf('%s/image_base.php/%s/%s?q=%s',
					__VIRTUAL_DIRECTORY__ . __PHP_ASSETS__,
					$this->strControlClassName,
					$strImageFilename,
					$strSerialized
				);
			}

			// Output or Display
			if ($blnDisplayOutput)
				print($strPath);
			else
				return $strPath;
		}

		/**
		 * Returns the HTML for rendering the control in the browser
		 *
		 * @return string HTML for the control
		 * @throws Exception
		 * @throws \QCubed\Exception\Caller
		 */
		protected function GetControlHtml() {
			try {
				// Figure Out the Path
				$strPath = $this->RenderAsImgSrc(false);
			} catch (\QCubed\Exception\Caller $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			if ($this->strCachedActualFilePath) {
				$objDimensions = getimagesize($this->strCachedActualFilePath);

				// Setup Style and Other Attribute Information (EXCEPT for "BackColor")
				// Use actual "Width" and "Height" values from cached image
				$strBackColor = $this->strBackColor;
				$strWidth = $this->strWidth;
				$strHeight = $this->strHeight;
				$this->strBackColor = null;
				$this->strWidth = $objDimensions[0];
				$this->strHeight = $objDimensions[1];
				$strStyle = $this->GetStyleAttributes();
				if ($strStyle)
					$strStyle = sprintf(' style="%s"', $strStyle);
				$this->strBackColor = $strBackColor;
				$this->strWidth = $strWidth;
				$this->strHeight = $strHeight;
			} else {
				// Setup Style and Other Attribute Information (EXCEPT for "BackColor", "Width" and "Height")
				$strBackColor = $this->strBackColor;
				$strWidth = $this->strWidth;
				$strHeight = $this->strHeight;
				$this->strBackColor = null;
				$this->strWidth = null;
				$this->strHeight = null;
				$strStyle = $this->GetStyleAttributes();
				if ($strStyle)
					$strStyle = sprintf(' style="%s"', $strStyle);
				$this->strBackColor = $strBackColor;
				$this->strWidth= $strWidth;
				$this->strHeight = $strHeight;
			}

			$strAlt = null;
			if ($this->strAlternateText)
				$strAlt = ' alt="' . QApplication::HtmlEntities($this->strAlternateText) . '"';

			// Render final "IMG SRC" tag
			$strToReturn = sprintf('<img src="%s" %s%s%s/>',
				$strPath,
				$this->GetAttributes(),
				$strStyle,
				$strAlt);
			return $strToReturn;
		}

		public function Serialize() {
			$objControl = clone($this);
			$objControl->objForm = null;
			$objControl->objParentControl = null;
			$objControl->strCacheFilename = null;
			$objControl->strCachedActualFilePath = null;
			$objControl->blnOnPage = null;
			$objControl->blnModified = null;
			$objControl->strControlId = null;
			$objControl->strRenderMethod = null;
			$objControl->blnOnPage = null;
			$objControl->blnRendered = null;
			$objControl->blnRendering = null;
			$objControl->objActionArray = null;
			$objControl->objChildControlArray = null;
			$objControl->blnWrapperModified = null;
			$objControl->strValidationError = null;
			$objControl->strWarning = null;

			$strData = serialize($objControl);

			if (function_exists('gzcompress'))
				$strData = base64_encode(gzcompress($strData, 9));
			else
				$strData = base64_encode($strData);

			$strData = str_replace('+', '-', $strData);
			$strData = str_replace('/', '_', $strData);
			
			return $strData;
		}
		
		public static function Run() {
			$strData = QApplication::QueryString('q');
			$strData = str_replace('-', '+', $strData);
			$strData = str_replace('_', '/', $strData);

			$strData = base64_decode($strData);

			if (function_exists('gzcompress'))
				$strData = gzuncompress($strData);

			$objControl = unserialize($strData);
			$objControl->RenderImage();
		}

		abstract public function RenderImage($strPath = null);

		/**
		 * Used by custom RenderImage method to output the final image.
		 * Uses $this->strImageType to determine type of image to be rendered.
		 * This version is to be used when rendering an image using the GD library.
		 * 
		 * If strPath is not set, output to the screen.  If it is, save to strPath.
		 *
		 * @param resource $objFinalImage image in GD format
		 * @param string $strPath
		 */
		protected function RenderImageHelper($objFinalImage, $strPath) {
			// Output the Image (if path isn't specified, output to buffer.  Otherwise, output to disk)
			if (!$strPath) {
				// Output to Output Stream
				QApplication::$ProcessOutput = false;
				header('Cache-Control: cache');
				header('Expires: Wed, 20 Mar 2019 05:00:00 GMT');
				header('Pragma: cache');

				switch ($this->strImageType) {
					case QImageType::Gif:
						header('Content-Type: image/gif');
						imagegif($objFinalImage);
						break;
					case QImageType::AnimatedGif:
						header('Content-Type: image/gif');
						imagegif($objFinalImage);
						break;
					case QImageType::Jpeg:
						header('Content-Type: image/jpeg');
						imagejpeg($objFinalImage, null, $this->intJpegQuality);
						break;
					default:
						header('Content-Type: image/png');
						imagepng($objFinalImage);
						break;
				}
			} else {
				// Make Directory
				QApplication::MakeDirectory(dirname($strPath), 0777);

				// Output to Disk
				switch ($this->strImageType) {
					case QImageType::Gif:
						imagegif($objFinalImage, $strPath);
						break;
					case QImageType::AnimatedGif:
						imagegif($objFinalImage, $strPath);
						break;
					case QImageType::Jpeg:
						imagejpeg($objFinalImage, $strPath, $this->intJpegQuality);
						break;
					default:
						imagepng($objFinalImage, $strPath);
						break;
				}
				chmod($strPath, 0777);
			}

			imagedestroy($objFinalImage);
		}

		/**
		 * Used by custom RenderImage method to output the final image.
		 * Uses $this->strImageType to determine type of image to be rendered.
		 * This version is to be used when rendering an image using the Imagick library.
		 * 
		 * If strPath is not set, output to the screen.  If it is, save to strPath.
		 *
		 * @param Imagick $objFinalImage image as an instance of the Imagick class
		 * @param string $strPath
		 */
		protected function RenderImageMagickHelper($objFinalImage, $strPath) {
			// Output the Image (if path isn't specified, output to buffer.  Otherwise, output to disk)
			if (!$strPath) {
				$strPath = $this->strImagickTempFilePath . '/image_' . str_replace('.', '_', microtime(true));

				// Output to a temporary location
				switch ($this->strImageType) {
					case QImageType::Gif:
						$strPath .= '.gif';
						$objFinalImage->setImageFormat('gif');
						header('Content-Type: image/gif');
						break;
					case QImageType::AnimatedGif:
						$strPath .= '.gif';
						$objFinalImage->setImageFormat('gif');
						header('Content-Type: image/gif');
						break;
					case QImageType::Jpeg:
						$strPath .= '.jpg';
						$objFinalImage->setImageFormat('jpeg');
						$objFinalImage->setCompressionQuality($this->intJpegQuality);
						header('Content-Type: image/jpeg');
						break;
					default:
						$strPath .= '.png';
						$objFinalImage->setImageFormat('png');
						header('Content-Type: image/png');
						break;
				}

				if ($this->strImageType == QImageType::AnimatedGif)
					file_put_contents($strPath, $objFinalImage->GetImagesBlob());
				else
					$objFinalImage->writeImage($strPath);

				QApplication::$ProcessOutput = false;
				header('Cache-Control: cache');
				header('Expires: Wed, 20 Mar 2019 05:00:00 GMT');
				header('Pragma: cache');

				print(file_get_contents($strPath));
				unlink($strPath);

			} else {
				// Make Directory
				QApplication::MakeDirectory(dirname($strPath), 0777);

				// Output to Disk
				switch ($this->strImageType) {
					case QImageType::Gif:
						$objFinalImage->setImageFormat('gif');
						break;
					case QImageType::AnimatedGif:
						$objFinalImage->setImageFormat('gif');
						break;
					case QImageType::Jpeg:
						$objFinalImage->setImageFormat('jpeg');
						$objFinalImage->setCompressionQuality($this->intJpegQuality);
						break;
					default:
						$objFinalImage->setImageFormat('png');
						break;
				}

				$objFinalImage->writeImage($strPath);
				chmod($strPath, 0777);
			}

			$objFinalImage->Destroy();
		}

		/////////////////////////
		// Public Properties: GET
		/////////////////////////
		/**
		 * PHP magic method to set a property of this class
		 *
		 * @param string $strName Name of the property
		 *
		 * @return int|mixed|null|string
		 * @throws Exception
		 * @throws \QCubed\Exception\Caller
		 */
		public function __get($strName) {
			switch ($strName) {
				// MISCELLANEOUS
				case "CacheFolder": return $this->strCacheFolder;
				case "CacheFilename": return $this->strCacheFilename;
				case "AlternateText": return $this->strAlternateText;
				case "ImageType": return $this->strImageType;
				case "JpegQuality": return $this->intJpegQuality;

				default:
					try {
						return parent::__get($strName);
					} catch (\QCubed\Exception\Caller $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		/////////////////////////
		// Public Properties: SET
		/////////////////////////
		/**
		 * PHP magic method to set the value of class properties
		 *
		 * @param string $strName Name of the property
		 * @param string $mixValue Value of the property
		 *
		 * @return mixed|void
		 * @throws Exception
		 * @throws \QCubed\Exception\Caller
		 * @throws \QCubed\Exception\InvalidCast
		 */
		public function __set($strName, $mixValue) {
			$this->blnModified = true;

			switch ($strName) {
				case "CacheFolder":
					try {
						$this->strCacheFolder = \QCubed\Type::Cast($mixValue, \QCubed\Type::STRING);
						break;
					} catch (\QCubed\Exception\InvalidCast $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case "CacheFilename":
					try {
						$this->strCacheFilename = \QCubed\Type::Cast($mixValue, \QCubed\Type::STRING);
						break;
					} catch (\QCubed\Exception\InvalidCast $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case "AlternateText":
					try {
						$this->strAlternateText = \QCubed\Type::Cast($mixValue, \QCubed\Type::STRING);
						break;
					} catch (\QCubed\Exception\InvalidCast $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case "ImageType":
					try {
						$this->strImageType = \QCubed\Type::Cast($mixValue, \QCubed\Type::STRING);
						break;
					} catch (\QCubed\Exception\InvalidCast $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case "JpegQuality":
					try {
						$this->intJpegQuality = \QCubed\Type::Cast($mixValue, \QCubed\Type::INTEGER);
						break;
					} catch (\QCubed\Exception\InvalidCast $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				default:
					try {
						parent::__set($strName, $mixValue);
					} catch (\QCubed\Exception\Caller $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;
			}
		}
	}