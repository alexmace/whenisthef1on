<?php

/**
 * Reformats a date in the standard British format of d/m/y into y-m-d for easy
 * insertion into a SQL database.
 * 
 * @author alexm
 *
 */
class Zend_Controller_Action_Helper_BritishDateToSqlDate extends 
    Zend_Controller_Action_Helper_Abstract 
{
	
	/**
	 * Implementing this as the "direct" function allows us to call this in this
	 * format from within a controller: $this->_helper->BritishDateToSql( )
	 * 
	 * @param string $britishDate
	 * @return string 
	 */
	public function direct( $britishDate )
	{
		
		// If the given date matches the format of a British date, process it.
		if ( Zend_Date::isDate( $britishDate, 'dd/MM/YYYY' ) )
		{
		
			// Split the date on slashes.
			$dateParts = explode( '/', $britishDate );
			
			// Get the year out. Default to 0000 if there is no year.
			if ( isset( $dateParts[2] ) )
			{
				
				$year = $dateParts[2];
				
			}
			else 
			{
				
				$year = '0000';
				
			}
			
			// Same for month, default to 00 if non exists
			if ( isset( $dateParts[1] ) )
			{
				
				$month = $dateParts[1];
				
			}
			else
			{
	
				$month = '00';
				
			}
			
			// Finally get the day of the month out. Default to 00.
			if ( isset( $dateParts[0] ) )
			{
				
				$day = $dateParts[0];
				
			}
			else
			{
				
				$day = '00';
				
			}
			
			// Construct date in SQL format
			$sqlDate = $year . '-' . $month . '-' . $day;
			
		}
		else 
		{
			
			// If original date wasn't in British format, just return default of
			// 0000-00-00
			$sqlDate = '0000-00-00';
			
		}
		
		return $sqlDate;
		
	}
	
}