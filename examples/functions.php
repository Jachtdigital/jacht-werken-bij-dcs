<?php

function get_vacancy_experience_label($code) {
	switch ($code) {
		case "mid_level":
			return "Middel niveau";
			break;
		case "entry_level":
			return "Start niveau";
			break;
		case "experienced":
			return "Ervaren";
			break;
		case "student_school":
			return "Student";
			break;
		// ... Eventueel aanvulllen
		default:
			return $code;
	}
}

function get_vacancy_working_time($min_hours, $max_hours) {
	if(!empty($min_hours) && empty($max_hours)) {
        return $min_hours;
    } elseif (empty($min_hours) && !empty($max_hours)) {
        return $max_hours;
    } elseif (!empty($min_hours) && !empty($max_hours)) {
        if($min_hours == $max_hours) {
           	return $min_hours;
        } else {
            return $min_hours . " - " . $max_hours;
        }
    }
}

function get_vacancy_employment_label($code) {
	switch ($code) {
		case "fulltime":
			return "Voltijd";
			break;
		case "parttime":
			return "Deeltijd";
			break;
		// ... Eventueel aanvulllen
		default:
			return $code;
	}
}

function get_vacancy_category_label($code) {
	switch ($code) {
		case "accountancy":
			return "Boekhouding";
			break;
		// ... Eventueel aanvulllen
		default:
			return $code;
	}
}

function get_vacancy_education_label($code) {
	switch ($code) {
		case "bachelor_degree":
			return "HBO";
			break;
		// ... Eventueel aanvulllen
		default:
			return $code;
	}
}

function get_vacancy_salary($min_salary, $max_salary) {
	if(!empty($min_salary) && empty($max_salary)) {
        return $min_salary;
    } elseif (empty($min_salary) && !empty($max_salary)) {
        return $max_salary;
    } elseif (!empty($min_salary) && !empty($max_salary)) {
        if($min_salary == $max_salary) {
           	return $min_salary;
        } else {
            return $min_salary . " - " . $max_salary;
        }
    }
}

function get_vacancy_salary_period_label($code) {
	switch ($code) {
		case "hour":
			return "Per uur";
			break;
		case "day":
			return "Per dag";
			break;
		case "week":
			return "Per week";
			break;
		case "month":
			return "Per maand";
			break;
		case "year":
			return "Per jaar";
			break;
		default:
			return $code;
	}
}