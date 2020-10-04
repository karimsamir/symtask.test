<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
    <div id="cards_container">
            <?php

            function calculateDistanceBetweenPoints($point1, $point2, $point3){

    
                $first_average = getAvgDistanceBetween2Points($point1, $point2);
                $second_average = getAvgDistanceBetween2Points($point2, $point3);
                
                $average = ($first_average + $second_average) / 2;

                return $average;

            }

            function getAvgDistanceBetween2Points($point1, $point2){
                // distance between first point and second point
                $x = $point2[0] - $point1[0];
                $y = $point2[1] - $point1[1];

                $x_sqr = gmp_strval(gmp_pow($x, 2));
                $y_sqr = gmp_strval(gmp_pow($y, 2));
                
                $total = $x_sqr + $y_sqr ;
                $average = sqrt($total) ;

                return $average;
            }
            
            // calculateDistanceBetweenPoints([3,2], [7,8], [9, 11]);


            function checkPalindrome($word){

                $strLength = strlen($word);
                $half = floor($strLength / 2);

                $splitted = str_split($word, $half);
                $rev = strrev($splitted[1]);
                if($rev == $splitted[0]){
                    return true;
                }
                else{
                    
                }
                die(var_dump($splitted));

            }
            checkPalindrome("abccba");


            ?>
    </div>
    </div>

    

</body>

</html>