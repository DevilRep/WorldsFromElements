export default function(next) {
    setTimeout(() => {
        alert('test2');
        next();
    }, 4000);
}