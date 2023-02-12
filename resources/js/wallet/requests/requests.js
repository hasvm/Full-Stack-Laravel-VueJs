import {fetchGet} from '../../helpers/requests';

// Requests for WalletController
export default {
    getWallet(id)
    {
        return fetchGet('/wallet/' + id);
    },
}