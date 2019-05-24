export default function(req, next) {
    setTimeout(() => {
        alert('test2');
        next();
    }, 4000);
}