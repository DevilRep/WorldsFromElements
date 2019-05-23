export default function(next) {
    setTimeout(() => {
        alert('test1');
        next();
    }, 2000);
};