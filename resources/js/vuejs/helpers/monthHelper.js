const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November',' December'];

const getMonthNumber = function (monthName) {
		return parseInt(Object.keys(months).find(key => months[key] === monthName));
}

export {months, getMonthNumber}
