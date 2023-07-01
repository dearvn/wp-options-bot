/**
 * External dependencies.
 */
import apiFetch from '@wordpress/api-fetch';

/**
 * Internal dependencies.
 */
import { optionsEndpoint } from './endpoint';

const controls = {
    FETCH_FROM_API(action) {
        return apiFetch({ path: action.path });
    },

    FETCH_FROM_API_UNPARSED(action: { path: any }) {
        return apiFetch({ path: action.path, parse: false }).then(
            (response: { headers: object; json: any }) =>
                Promise.all([response.headers, response.json()]).then(
                    ([headers, data]) => ({ headers, data })
                )
        );
    },

    CREATE_OPTIONS(action) {
        return apiFetch({
            path: optionsEndpoint,
            method: 'POST',
            data: action.payload,
        });
    },

    UPDATE_OPTIONS(action) {
        const path = optionsEndpoint + '/' + action.payload.id;
        return apiFetch({ path, method: 'PUT', data: action.payload });
    },

    DELETE_OPTIONS(action) {
        const path = optionsEndpoint;
        return apiFetch({ path, method: 'DELETE', data: action.payload });
    },
};

export default controls;
