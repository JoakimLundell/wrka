from fabric.api import cd, env, put, run, sudo, task
import uuid


env.hosts = [
    'ns12.inleed.net',
]
env.use_ssh_config = True

project_path = '/public_html'
rev = None


def reset_permissions():
    """Resets file ownership in html root"""
    with cd(project_path):
        sudo('chgrp -R iladmins ./*')
        sudo('chgrp -R iladmins ./.git')

        # Deal with hidden files manually...
        for v in ['.gitignore', 'public/.htaccess']:
            sudo('chgrp -R iladmins {}'.format(v))


def get_revision():
    """Gets a GUID which stays the same for this session"""
    global rev
    if rev is None:
        rev = uuid.uuid1()
    return rev


# @task
def bump_revision():
    """Sets APP_VERSION to a unique ID used for cache busting"""
    with cd(project_path):
        run('sed -i "s/APP_VERSION=.*/APP_VERSION=' + str(get_revision()) + '/g" .env')


@task
def deploy():
    """Deploys project to production environment"""

    with cd(project_path):
        run('git checkout master')
        #run('git pull')
        #run('composer install')
        #run('composer dump-autoload -o')
        #put('public/dist', 'public')
        #run('rm public/dist/*.map')

    #bump_revision()
    #reset_permissions()
