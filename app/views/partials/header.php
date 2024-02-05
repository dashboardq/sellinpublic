        <header>
            <div class="box">
                <h2><a href="/"><img src="/assets/images/logo.svg" class="logo" alt="Logo"><?php esc(ao()->env('APP_NAME')); ?></a></h2>
                <nav>
                    <menu>
                        <li><a href="/">Latest</a></li>
                        <li><a href="/about">About</a></li>
                        <?php if($user): ?>
                        <li><a href="/post">Post</a></li>
                        <li><a href="/pending">Pending</a></li>
                        <li><a href="/account">Account</a></li>
                        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();">Logout</a></li>
                        <?php else: ?>
                        <li><a href="/login">Create Account / Login</a></li>
                        <?php endif; ?>
                    </menu>
                </nav>
            </div>
        </header>
