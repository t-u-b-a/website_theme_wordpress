(function () {
    var hero = document.getElementById('fpHero');
    var img = hero.getElementsByTagName('img')[0];

    var getPageHeight = function () {
        var body = document.body;
        var html = document.documentElement;
        return Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
    };
    var getMoveRange = function () {
        var heroHeight = hero.clientHeight;
        var imgHeight = img.clientHeight;
        return imgHeight - heroHeight;
    };
    var getMoveIndex = function () {
        var result = moveRange / scrollDistance;
        return Math.min(result, 0.3);
    };
    var posY = window.pageYOffset;
    var pageHeight = getPageHeight();
    var windowHeight = window.innerHeight;
    var windowWidth = window.innerWidth;
    var scrollDistance = pageHeight - windowHeight;
    var getParallex = function (posY, moveIndex, moveRange) {
        var initPos = Math.min(50, moveRange);
        var distance = (posY * moveIndex)  - initPos;
        return distance;
    };
    var moveRange = getMoveRange();
    var moveIndex = getMoveIndex();
    if (hero && windowWidth > 737) {
        window.addEventListener('resize', function () {
            windowHeight = window.innerHeight;
            scrollDistance = pageHeight - windowHeight;
            moveIndex = getMoveIndex();
        });
        window.addEventListener('scroll', function () {
            posY = window.pageYOffset;
            img.style.top = getParallex(posY, moveIndex, moveRange) + 'px';
        });
        img.style.top = getParallex(posY, moveIndex, moveRange) + 'px';
    }
})();