var Helper = class {
    constructor(options) {

    }

    convertStringPriceToNumber(strPrice) {
        if (typeof strPrice === 'number' && strPrice > 0) return strPrice;
        if (typeof strPrice !== 'string') return 0;

        const cleanStr = strPrice.replace(/[,|.]/g, '');
        return parseFloat(cleanStr);
    }
}