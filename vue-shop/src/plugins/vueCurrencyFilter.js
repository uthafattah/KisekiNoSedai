import Vue from 'vue';
import VueCurrencyFilter from 'vue-currency-filter'

Vue.use(VueCurrencyFilter,
{
    symbol : 'Rp.',
    thousandsSeparator: '.',
    fractionCount: 0,
    fractionSeparator: ',',
    symbolPosition: 'front',
    symbolSpacing: true
})

export default ({
});
