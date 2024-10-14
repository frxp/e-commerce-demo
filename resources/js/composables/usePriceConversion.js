export const usePriceConversion = (priceInCents) => {
    return (priceInCents / 100).toFixed(2);
};
