

    <footer>
        <h1><span>&#169;</span>2024 ScoutTheBest</h1>

    </footer>

    <script>
        button = document.querySelector('.hamburger');
        button.onclick = function(){
            navbar = document.querySelector('.nav-bar');
            navbar.classList.toggle('active');
            document.querySelector('header').classList.toggle('overlap');
            footer = document.querySelector('footer');
            footer.classList.toggle('footer-margin-top');
        }

        window.onresize = function(){
            if(window.innerWidth > 900){
                document.querySelector('.nav-bar').classList.remove('active');
                document.querySelector('header').classList.remove('overlap');
                document.querySelector('footer').classList.remove('footer-margin-top');
            }
        }

    </script>
</body>
</html>