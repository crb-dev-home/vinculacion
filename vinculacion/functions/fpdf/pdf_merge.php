<?php
/**
 *  PDFMerger created by Jarrod Nettles December 2009
 *  jarrod@squarecrow.com
 *  
 *  v1.0
 * 
 * Class for easily merging PDFs (or specific pages of PDFs) together into one. Output to a file, browser, download, or return as a string.
 * Unfortunately, this class does not preserve many of the enhancements your original PDF might contain. It treats
 * your PDF page as an image and then concatenates them all together.
 * 
 * Note that your PDFs are merged in the order that you provide them using the addPDF function, same as the pages.
 * If you put pages 12-14 before 1-5 then 12-15 will be placed first in the output.
 * 
 * 
 * Uses FPDI 1.3.1 from Setasign
 * Uses FPDF 1.6 by Olivier Plathey with FPDF_TPL extension 1.1.3 by Setasign
 * 
 * Both of these packages are free and open source software, bundled with this class for ease of use. 
 * They are not modified in any way. PDFMerger has all the limitations of the FPDI package - essentially, it cannot import dynamic content
 * such as form fields, links or page annotations (anything not a part of the page content stream).
 * 
 */
class pdf_merge
{
	private $_files;	//['form.pdf']  ["1,2,4, 5-19"]
	private $_fpdi;
	
	/**
	 * Merge PDFs.
	 * @return void
	 */
	public function __construct()
	{
		require_once('fpdf.php');
		require_once('fpdi.php');
	}
	
	/**
	 * Add a PDF for inclusion in the merge with a valid file path. Pages should be formatted: 1,3,6, 12-16. 
	 * @param $filepath
	 * @param $pages
	 * @return void
	 */
	public function addPDF($filepath)
	{
		$this->_files[] = array($filepath);
		return $this;
	}
	
	/**
	 * Merges your provided PDFs and outputs to specified location.
	 * @param $outputmode
	 * @param $outputname
	 * @return PDF
	 */
	public function merge($outputmode = 'browser', $outputpath = 'newfile.pdf')
	{
		if(!isset($this->_files) || !is_array($this->_files)): throw new exception("No PDFs to merge."); endif;
		
		$fpdi = new FPDI;
		
		//merger operations
		foreach($this->_files as $file)
		{
			$filename  = $file[0];
			$url  = $file[0];

			#$page = file_get_contents($url);

			$count = $fpdi->setSourceFile($filename);

				for($i=1; $i<=$count; $i++)
				{
					$template 	= $fpdi->importPage($i);
					$size 		= $fpdi->getTemplateSize($template);
					
					$fpdi->AddPage('P', array($size['w'], $size['h']));
					$fpdi->useTemplate($template);
				}

		}

		//output operations
		$mode = $this->_switchmode($outputmode);
		

		$fpdi->Output($outputpath, $mode);

		
		
	}
	
	/**
	 * FPDI uses single characters for specifying the output location. Change our more descriptive string into proper format.
	 * @param $mode
	 * @return Character
	 */
	private function _switchmode($mode)
	{
		switch(strtolower($mode))
		{
			case 'download':
				return 'D';
				break;
			case 'browser':
				return 'I';
				break;
			case 'file':
				return 'F';
				break;
			default:
				return 'I';
				break;
		}
	}
	

}