<?php

class calendar {

    
    private $year;
    private $month;
    private $weeks = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
    private $isSun;
    private $isTitlehide;
    private $isMonthHide;
    private $isYearHide;

    
    function _Setsun($flag) {
        $this->isSun = $flag;
    }

    function _SetTitlehide($flag) {
        $this->isTitlehide = $flag;
    }

    function _setMonth($flag) {
        $this->isMonthHide = $flag;
    }

    function _setYear($flag) {
        $this->isYearHide = $flag;
    }

    function __construct($option = array()) {
        date_default_timezone_set('Asia/JAPAN');
        $this->year = date('Y');
        $this->month = date('m');
        $ODList = get_class_vars(get_class($this));
        foreach ($option as $key => $value) {
            if (array_key_exists($key, $ODList)) {
                $this->$key = $value;
            }
        }
    }

    function _getYear() {
        return $this->year;
    }

    function _getMonth() {
        return $this->month;
    }

    function _darwTitle() {
        if ($this->isTitlehide == 'y')
            echo '<tr style = "visibility:hidden">';
        else
            echo '<tr>';
        foreach ($this->weeks as $title) {
            echo '<th >' . $title . '</th>';
        }
        echo "</tr>";
    }

    function _drawDays($month, $year) {
		global $M;
        date_default_timezone_set('Asia/Shanghai');
        $today = mktime(0, 0, 0, $month, 1, $year);
        $startday = date('w', $today);
        $days = date('t', $today);
        echo "<tr>";
        for ($i = 0; $i < $startday; $i++) {
            echo '<td>&nbsp;</td>';
        }
        for ($j = 1; $j <= $days; $j++) {
            $i++;
			
			$riqiA="$year".str_pad($month,2,0,STR_PAD_LEFT).str_pad($j,2,0,STR_PAD_LEFT);
			$O=mysql_fetch_assoc(mysql_query("select * from orders where carid='".intval($_GET['id'])."' and find_in_set('$riqiA',zdates)"));
            if($O['id']||strtotime($riqiA."23:59:59")<time()) {
				 $kyd=0;
				 $myclass=" style='background-color:#FFCC33'";
				 $id="b".$riqiA;				 
			}
			else {
				$kyd=1;
				$myclass=" style='background-color:#66CC66'";
				$id="r".$riqiA;
			}
            			
            if ($j == date('j') && $month == date('n') && $year == date('Y')) {
                echo '<td class = "today"  id="'.$id.'"  onclick="yuding('.$kyd.',\''.$riqiA.'\')" '.$myclass.'><span>' .$j . '</span></td>';
            } elseif ($i % 7 == 1) {
                if ($this->isSun == 'y')
                    echo '<td class ="sunday" id="'.$id.'" onclick="yuding('.$kyd.',\''.$riqiA.'\')" '.$myclass.'><span>' .$j . '</span></td>';
                else
                    echo '<td id="'.$id.'" onclick="yuding('.$kyd.',\''.$riqiA.'\')" '.$myclass.'><span>' .$j . '</span></td>';
            } else {
                echo '<td id="'.$id.'" onclick="yuding('.$kyd.',\''.$riqiA.'\')" '.$myclass.'><span>' .$j . '</span></td>';
            }
            if ($i % 7 == 0) {
                echo "</tr>";
                echo "<tr>";
            }
        }
        echo "</tr>";
    }

    
    function _dateChange() {
		$fsql="&action=show&id=".intval($_GET['id']).'&';
        date_default_timezone_set('Asia/Shanghai');
        $m_URL = basename($_SERVER['PHP_SELF']);
        echo '<tr>';
        echo '<td><a href="?'.$fsql.$this->_preYearURL($this->year, $this->month) . '">' . '<<' . '</a></td>';
        echo '<td><a href="?'.$fsql. $this->_preMonthURL($this->year, $this->month) . '">' . '<' . '</a></td>';
        echo '<td colspan = "3"><form>';
        echo '<select name="year" onchange="window.location=\'' . $m_URL . '?'.$fsql.'year=\'+this.options[selectedIndex].value+\'&month=' . $this->month . '\'">';
        for ($ye = 1970; $ye <= 2038; $ye++) {
            if ($ye == $this->year) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            echo '<option ' . $selected . ' value="' . $ye . '">' . $ye . '</option>';
        }
        echo '</select>';
        echo '<select name="month" onchange="window.location=\'' . $m_URL . '?'.$fsql.'year=' . $this->year . '&month=\'+this.options[selectedIndex].value+\'\'">';
        for ($mo = 1; $mo <= 12; $mo++) {
            if ($mo == $this->month) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            echo '<option ' . $selected . ' value="' . $mo . '">' . $mo . '</option>';
        }
        echo '</select>';
        echo '</form></td>';
        echo '<td><a href="?'.$fsql . $this->_nextMonthURL($this->year, $this->month) . '">' . '>' . '</a></td>';
        echo '<td><a href="?'.$fsql . $this->_nextYearURL($this->year, $this->month) . '">' . '>>' . '</a></td>';
        echo '</tr>';
    }

    
    function _preYearURL($year, $month) {
        date_default_timezone_set('Asia/Shanghai');
        if ($year <= 1970) {
            $year = 1970;
        } else {
            $year = $year - 1;
        }
        return 'year=' . $year . '&month=' . $month;
    }

    
    function _nextYearURL($year, $month) {
        date_default_timezone_set('Asia/Shanghai');
        if ($year >= 2038) {
            $year = 2038;
        } else {
            $year = $year + 1;
        }
        return 'year=' . $year . '&month=' . $month;
    }

    
    function _preMonthURL($year, $month) {
        date_default_timezone_set('Asia/Shanghai');
        if ($month == 1) {
            $month = 12;
            if ($year <= 1970) {
                $year = 1970;
            } else {
                $year--;
            }
        } else {
            $month--;
        }
        return 'year=' . $year . '&month=' . $month;
    }

    
    function _nextMonthURL($year, $month) {
        date_default_timezone_set('Asia/Shanghai');
        if ($month == 12) {
            $month = 1;
            if ($year >= 2038) {
                $year = 2038;
            } else {
                $year++;
            }
        } else {
            $month++;
        }
        return 'year=' . $year . '&month=' . $month;
    }

    
    function _drawCalendar() {
        echo '<table class="calendar" width=100% height=400>';
        $this->_dateChange();
        $this->_darwTitle();
        $this->_drawDays($this->month, $this->year);
        echo '</table>';
    }

    function _draw3Mview() {

        echo '<table class = "3monthView">';

        echo "<tr>";

        echo "<td>";
        echo '<div id =1>';
        if ($this->isMonthHide == "y") echo '<label class = "month" style = "visibility:hidden">' . ($this->_getMonth() - 1) . '</label>';
        else echo '<label class = "month">' . ($this->_getMonth() - 1) . '</label>';
        echo '<table class = "calendar"  cellspacing="23">';
        $this->_darwTitle();
        $this->_drawDays(($this->month - 1), $this->year);
        echo '</table>';
        echo '</div>';
        echo "</td>";


        echo "<td>";

        echo '<table class = "calendar" cellspacing="23">';
        $this->_dateChange();
        $this->_darwTitle();
        $this->_drawDays($this->month, $this->year);
        echo '</table>';
        echo '</div>';
        echo "</td>";

        echo "<td>";
        echo '<div id =2>';
        if ($this->isMonthHide == "y")
            echo '<label class = "month" style = "visibility:hidden">' . ($this->_getMonth() + 1) . '</label>';
        else
            echo '<label class = "month">' . ($this->_getMonth() + 1) . '</label>';
        echo '<table class = "calendar" cellspacing="23">';
        $this->_darwTitle();
        $this->_drawDays(($this->month + 1), $this->year);
        echo '</table>';
        echo '<div id =2>';
        echo "</td>";

        echo "</tr>";
        echo '</table>';
    }

    function _draw12Mview() {
        if ($this->isYearHide == "y")
            echo'<label class = "month" style="visibility:hidden">' . $this->_getYear() . '</label>';
        else
            echo'<label class = "month">' . $this->_getYear() . '</label>';
        echo '<table class = "12monthView">';
        $n = 0;
        echo "<tr>";
        for ($i = 1; $i < $this->month; $i++) {
            $n++;
            echo '<td>';
            echo '<div id = "m">';
            if ($this->isMonthHide == "y")
                echo '<label class = "month" style="visibility:hidden">' . $i . '</label>';
            else
                echo '<label class = "month">' . $i . '</label>';
            echo '<table class = "calendar" cellspacing="23">';
            $this->_darwTitle();
            $this->_drawDays($i, $this->year);
            echo '</table>';
            echo '</div>';
            echo '</td>';
            if ($n % 3 == 0) {
                echo '</tr>';
                echo '<tr>';
            }
        }

        echo "<td>";
        echo '<table class = "calendar" cellspacing="23"">';
        $this->_dateChange();
        $this->_darwTitle();
        $this->_drawDays($this->month, $this->year);
        echo '</table>';
        echo "</td>";
        $n++;

        if ($n % 3 == 0) {
            echo '</tr>';
            echo '<tr>';
            for ($j = $this->month + 1; $j <= 12; $j++) {
                echo "<td>";
                echo '<div id = "m">';
                echo '<label style="font-size:20px">' . $j . '</label>';
                echo '<table class = "calendar" cellspacing="23">';
                $this->_darwTitle();
                $this->_drawDays($j, $this->year);
                echo '</table>';
                echo '</div>';
                echo "</td>";
                $n++;
                if ($n % 3 == 0) {
                    echo '</tr>';
                    echo '<tr>';
                }
            }
        } else {
            for ($j = $this->month + 1; $j <= 12; $j++) {
                echo "<td>";
                echo '<div id = "m">';
                echo '<label style="font-size:20px">' . $j . '</label>';
                echo '<table class = "calendar" cellspacing="23">';
                $this->_darwTitle();
                $this->_drawDays($j, $this->year);
                echo '</table>';
                echo '</div>';
                echo "</td>";
                $n++;
                if ($n % 3 == 0) {
                    echo '</tr>';
                    echo '<tr>';
                }
            }
        }
        echo '<tr>';
        echo '</table>';
    }

    function _drawLinearView() {
        echo '<table class = "calendar">';
        echo'<tr>';
        echo '<td>';
        echo'<table class = "selectbox">';
        $this->_dateChange();
        echo '</td>';
        echo'</tr>';
        echo'</table>';

        echo '<table class = "title" style = "float:left">';
        echo '<tr>';
        echo '<td>';
        $this->_drawLineTitle();
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '<table class = "LineView" style = "float:left margin-left:8px">';
        $this->_LinearView($this->month, $this->year);
        echo '</table>';
    }

    function _drawLineTitle() {
        if ($this->isTitlehide == 'y') {
            for ($i = 0; $i <= 5; $i++) {
                foreach ($this->weeks as $title) {
                    echo '<tr style = "visibility:hidden">';
                    echo '<td>' . $title . '<td>';
                    echo '</tr>';
                }
            }
        } else {
            for ($i = 0; $i <= 5; $i++) {
                foreach ($this->weeks as $title) {
                    echo '<tr>';
                    echo '<td>' . $title . '<td>';
                    echo '</tr>';
                }
            }
        }
    }

    function _LinearView($month, $year) {
        date_default_timezone_set('Asia/Shanghai');
        $today = mktime(0, 0, 0, $month, 1, $year);
        $startday = date('w', $today);
        $e_stratday = date('D', $today);
        $days = date('t', $today);

        for ($i = 0; $i < $startday; $i++) {
            echo "<tr>";
            echo '<td>&nbsp;</td>';
            echo "<tr>";
        }
        for ($j = 1; $j <= $days; $j++) {
            $i++;
            echo '<tr>';
            if ($j == date('j') && $month == date('n') && $year == date('Y')) {

                echo '<td class = "today">' . $j . '</td>';
            } elseif ($i % 7 == 1) {
                if ($this->isSun == 'y')
                    echo '<td class ="sunday">' . $j . '</td>';
                else
                    echo '<td>' . $j . '</td>';
            }
            else {
                echo '<td>' . $j . '</td>';
            }
            echo "</tr>";
        }
    }

    function _draw3LinearView() {
        echo '<table class = "calendar">';
        echo'<tr>';
        echo '<td>';
        echo'<table class = "selectbox">';
        $this->_dateChange();
        echo '</table>';
        echo '</td>';
        echo'</tr>';
        echo'</table>';

        echo '<div style = "float:left">';
        echo'<table class = "title" style = "float:left">';
        $this->_drawLineTitle();
        echo'</table>';
        echo '<div id ="1" style = "float:left">';

        if ($this->isMonthHide == "y")
            echo '<lable id = "m" style = "visibility:hidden">' . ($this->_getMonth() - 1) . '月</lable>';
        else
            echo '<lable id = "m">' . ($this->_getMonth() - 1) . '月</lable>';
        echo '<table class = "LineView" style = "float:left margin-left:8px">';

        $this->_LinearView($this->month - 1, $this->year);
        echo '</table>';
        echo '</div>';
        echo '<div id ="2" style = "float:left" margin>';
        if ($this->isMonthHide == "y")
            echo '<lable id = "m" style = "visibility:hidden">' . $this->_getMonth() . '月</lable>';
        else
            echo '<lable id = "m">' . $this->_getMonth() . '月</lable>';
        echo '<table class = "LineView" style = "float:left margin-left:8px">';
        $this->_LinearView($this->month, $this->year);
        echo '</table>';
        echo '</div>';
        echo '<div id ="3" style = "float:left">';
       if ($this->isMonthHide == "y")
            echo '<lable id = "m" style = "visibility:hidden">' . ($this->_getMonth() +1) . '月</lable>';
        else
            echo '<lable id = "m">' . ($this->_getMonth() +1) . '月</lable>';
        echo '<table class = "LineView" style = "float:left margin-left:8px">';
        $this->_LinearView($this->month + 1, $this->year);
        echo '</table>';
        echo '</div>';
    }

    function _draw12LinearView() {
        echo '<table class = "calendar">';
        echo'<tr>';
        echo '<td>';
        echo'<table class = "selectbox">';
        $this->_dateChange();
        echo'</table>';
        echo '</td>';
        echo'</tr>';
        echo '</table>';
        echo '<div id ="1" style = "float:left">';
        echo'<table class = "title" style = "float:left">';
        $this->_drawLineTitle();
        echo'</table>';
        echo '</div>';

        for ($i = 1; $i <= 12; $i++) {
            echo '<div  style = "float:left">';
            if ($this->isMonthHide == "y")
            echo '<lable id = "m" style = "visibility:hidden">' . $i . '月</lable>';
        else
            echo '<lable id = "m">' . $i . '月</lable>';
            echo '<table class = "LineView" style = "float:left margin-left:8px">';
            $this->_LinearView($i, $this->year);
            echo '</table>';
            echo '</div>';
        }
    }

}

?>
