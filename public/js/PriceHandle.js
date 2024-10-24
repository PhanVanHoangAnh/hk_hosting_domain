const PriceHandle = class {
    constructor(options) {
        this.rawPrice = this.cleanAndConvertToNumber(options.rawPrice);
    }

    getRawPrice() {
        return this.rawPrice;
    }

    cleanAndConvertToNumber(rawPrice) {
        let cleanedPrice = rawPrice.toString().replace(/[\s\,\.\-\_]/g, '');
        
        if (/^\d+$/.test(cleanedPrice)) {
            return parseFloat(cleanedPrice);
        } 
        
        return 0;
    }

    toStringNumberWithCommas() {
        const number = this.getRawPrice();

        if (typeof number === 'string') {
            number = number.replace(/[,\.]/g, '');
        }
    
        const numString = number.toString();
        const decimalIndex = numString.indexOf('.');
        const integerPart = decimalIndex > -1 ? numString.slice(0, decimalIndex) : numString;
        const decimalPart = decimalIndex > -1 ? numString.slice(decimalIndex) : '';
        const formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        const result = formattedInteger + decimalPart;
    
        return result;
    }

    toNumber() {
        const strPrice = this.getRawPrice();

        if (typeof strPrice === 'string' && !isNaN(parseFloat(strPrice)) && isFinite(strPrice)) {
            return parseFloat(strPrice);
        }

        if (typeof strPrice === 'number') return strPrice;

        const cleanStr = strPrice.replace(/[,.]/g, '');
        const floatNum = parseFloat(cleanStr);
    
        return floatNum || 0;
    }
}