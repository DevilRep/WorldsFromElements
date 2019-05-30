let result = {};
const files = require.context('./', true, /\.js$/i);
files.keys().map(key => {
    if (key === '/index.js') {
        return;
    }
    result[key.split('/').pop().split('.')[0]] = files(key).default
});

export default result;