<?php namespace Xethron;

class ToString
{

	/**
	 * This function will convert any variable to a string representation of that variable
	 *
	 * @param  array  $var            The variable to print
	 * @param  int    $max_lines      Maximum number of lines that can be used
	 * @param  int    $max_depth      Maximum depth to print
	 * @param  int    $min_depth      Minimum depth to print
	 * @return string                 String representation of Variable
	 */
	public static function variable( $var, $max_lines = 40, $max_depth = 6, $min_depth = 2 )
	{
		return ToString::_varToString( $var, $max_lines, $max_depth, $min_depth )['text'];
	}

	/**
	 * Recursive function to print out variables much like print_r
	 *
	 * @param  array  $var            The variable to print
	 * @param  int    $max_lines      Maximum number of lines that can be used
	 * @param  int    $max_depth      Maximum depth to print
	 * @param  int    $min_depth      Minimum depth to print
	 * @param  int    $depth          Current Depth
	 * @param  int    $lines          Current Lines Used
	 * @param  int    $lines_reserved Lines reserved for previous array depth
	 * @param  int    $indent         How much indentation to start on
	 * @return string                 String representation of Variable
	 */
	protected static function _varToString( $var, $max_lines, $max_depth, $min_depth, $depth = 0, $lines = 1, $lines_reserved = 0, $indent = 0 )
	{
		if ( is_string( $var ) ) {
			$return = "\"" . $var . "\"";
		} elseif ( is_array( $var ) ) {
			$return = ToString::print_array( $var, $max_lines, $max_depth, $min_depth, $depth, $lines, $lines_reserved, $indent );
		} elseif ( is_null( $var ) ) {
			$return = 'NULL';
		} elseif ( is_bool( $var ) ) {
			$return = ( $var ) ? 'true' : 'false';
		} elseif ( is_object( $var ) ) {
			$return = 'Object( '. get_class( $var ) .' )';
		} elseif ( is_resource( $var ) ) {
			$return = 'Resource( '. get_resource_type( $var ) .' )';
		} else {
			$return = $var;
		}
		if ( is_array( $return ) ) {
			return $return;
		} else {
			return [ 'text' => $return, 'lines' => 1 ];
		}
	}

	/**
	 * Recursive function to print out arrays much like print_r
	 *
	 * @param  array  $array          The array to print
	 * @param  int    $max_lines      Maximum number of lines that can be used
	 * @param  int    $max_depth      Maximum depth to print
	 * @param  int    $min_depth      Minimum depth to print
	 * @param  int    $depth          Current Depth
	 * @param  int    $lines          Current Lines Used
	 * @param  int    $lines_reserved Lines reserved for previous array depth
	 * @param  int    $indent         How much indentation to start on
	 * @return string                 String representation of Array
	 */
	protected static function print_array( $array, $max_lines, $max_depth, $min_depth, $depth, $lines, $lines_reserved, $indent )
	{
		$start_lines = $lines;
		$lines++;
		$count = count( $array );
		if (
			! empty( $array ) &&
			$depth < $max_depth &&
			(
				( $depth <= $min_depth && $lines + $depth + 2 < $max_lines ) ||
				( $depth > $min_depth && ( $lines + $lines_reserved - 1 ) < $max_lines )
			)
		) {
			$lines += 2;
			$return = "Array\n" . ToString::indent( "(\n", $indent );
			$indent++;
			foreach ( $array as $key => $value ) {
				$result = ToString::_varToString( $value, $max_lines, $max_depth, $min_depth, $depth + 1, $lines, $lines_reserved + $count, $indent + 1 );
				$count--;
				$lines += $result['lines'];
				$return .= ToString::indent( "[$key] => ". $result['text'] ."\n", $indent );

				if ( ( ( $depth <= $min_depth && ( $lines + $depth ) > $max_lines ) || ( $depth > $min_depth && ( $lines + $lines_reserved ) >= $max_lines + $depth ) ) && ( $count != 1 ) ) {
					if ( $count > 0 ) {
						$return .= ToString::indent( "... ($count)\n", $indent );
						$lines++;
					}
					break;
				}
			}
			$indent--;
			$return .= ToString::indent( ")", $indent );
		} else {
			if ( ! empty( $array ) ) {
				$return = "Array($count)";
			} else {
				$return = "Array()";
			}
		}
		return [ 'text' => $return, 'lines' => ( $lines - $start_lines ) ];
	}

	/**
	 * Indent current string
	 *
	 * @param  string $string String to indent
	 * @param  int    $indent Number of Indentations
	 * @param  string $tab    What a tab should look like
	 * @return string         Indented String
	 */
	protected static function indent( $string, $indent, $tab = "    " )
	{
		$pre = '';
		for ( $i = 0; $i < $indent; $i++ ) {
			$pre .= $tab;
		}
		return $pre . $string;
	}

	/**
	 * Converts an Exception to string
	 *
	 * This try's to replicate PHP's __toString for exceptions, however, it doesn't cut off
	 * long strings and also shows variables
	 * @param  Object $e Exception Object
	 * @return string    Exception as String
	 */
	public static function exception( $e )
	{
		$class = get_class( $e );
		$file = $e->getFile();
		$lineNr = $e->getLine();
		$message = $e->getMessage();
		$code = "";
		if ( $e->getCode() )
			$code = ' and code \''. $e->getCode() .'\'';
		$exceptionAsString = "Exception '$class' with message '$message'$code in $file:$lineNr\nStack trace:\n\n";
		$exceptionAsString .= ToString::trace( $e->getTrace() );


		return $exceptionAsString;
	}

	/**
	 * Convert exception trace array to string
	 *
	 * @param  array/object $trace Exception or trace array to convert to string
	 * @return string                 String of Exception trace
	 */
	public static function trace( $trace )
	{
		if ( is_object( $trace ) ) {
			$trace = $trace->getTrace();
		}
		if ( ! is_array( $trace ) ) {
			return false;
		}

		$traceAsString = "";
		$count = 0;
		foreach ( $trace as $frame ) {
			$args = "";
			if ( isset( $frame['args'] ) ) {
				$args = array();
				$expanded_args = "";
				foreach ( $frame['args'] as $arg ) {
					$args[] = ToString::variable( $arg, 1 );
					foreach( preg_split( "/(\n)/", ToString::variable( $arg ) ) as $line )
						$expanded_args .= "#    $line\n";
				}
				$args = join( ", ", $args );
			}

			if ( isset( $frame['file'] ) )
				$format = "#%s %s(%s): %s(%s)\n%s\n\n";
			else
				$format = "#%s [internal function]: %4\$s(%5\$s)\n%6\$s\n\n";

			$traceAsString .= sprintf( $format,
				$count,
				isset( $frame['file'] ) ? $frame['file'] : 'unknown file',
				isset( $frame['line'] ) ? $frame['line'] : 'unknown line',
				( isset( $frame['class'] ) ) ? $frame['class'].$frame['type'].$frame['function'] : $frame['function'],
				$args ? " $args " : "",
				$expanded_args
			);
			$count++;
		}

		return $traceAsString;
	}
}