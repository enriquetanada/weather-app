import Vue from 'vue';
import axios from 'axios';

let queries = {
    getWeather: `query getWeather($city: String) {
        getWeather(city: $city)  {
            error,
            message,
            forecasts {
                min_temp,
                max_temp,
                feels_like,
                temp,
                date,
                weather,
                wind_speed,
                pop
            }
        }
    }`
}

let adminQueries = [];

function getApiUrl(queryName) {
    let segment = '';

    if(adminQueries.some(q => q == queryName)){
        segment = "/administrator";
    }

    return `/graphql${segment}`;
}

Vue.prototype.$query = function (queryName, queryVariables) {
    let token;

    if(adminQueries.some(q => q == queryName)) {
        token = sessionStorage.getItem('api-token');
    }

    let options = {
        url: getApiUrl(queryName),
        method: 'POST',
        data: {
            query: queries[queryName]
        }
    }

    if(queryVariables) options.data.variables = queryVariables;

    if(token) {
        options.headers = {
            Authorization: `Bearer ${token}`,
        }
    }
    return axios(options);
}