ToString
========

Logging variables can sometimes cause huge logs, especially if you want to email those logs to yourself.

On the other hand, logging exceptions with the default __toString can will most likely give you just enough information to confuse the hell out of you!

Variable to String
==================

This is a function that will display a variable similar to print_r, with the ability to specify the max_lines, max_depth (for arrays) and min_depth (for arrays).

This means that you will never get an email with an array 3000 lines long as you would with print_r.

`Xethron\ToString::variable( $var, $max_lines, $max_depth, $min_depth )`

I recommend adding a global function to one of your startup files for easier access:

```php
function varToStr( $var, $max_lines = 10, $max_depth = 4, $min_depth = 2 )
{
    return Xethron\ToString::variable( $var, $max_lines, $max_depth, $min_depth );
}
```
Exception to String
===================

This converts an Exception to string, much like PHP's __toString, however, it won't cut off those important pieces of information you require while debugging.

On top of that, it also uses the Variable to String to to include all the variables passed in the Stack Trace.

Two functions are available:
---------------------------

`Xethron\ToString::exception( $e ); // This will print out the entire Exception`

`Xethron\ToString::trace( $e->getTrace() ); // This will only print out the stack trace`

License
=======

ToString is distributed under the terms of the GNU General Public License, version 3 or later.