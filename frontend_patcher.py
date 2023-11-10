import getopt
import json
import sys
from pathlib import Path
import zipfile
from zipfile import ZipFile
import os

basic_files = ["manifest.json", "robots.txt"]

manifest_file_name = "asset-manifest.json"


def usage():
    print('\nUsage -h -s [path to zip archive] -t [path to laravel project]\n\n'
          '\t -h --help \t Show this message \n'
          '\t -b --beta \t If set the beta version is replaced \n'
          '\t -s --source \t Path of the build react project as zip archive \n'
          '\t -t --target \t Path to the root of the laravel project')


def main(argv):
    try:
        opts, args = getopt.getopt(argv, 'hbs:t:', ['help', 'beta', 'source', 'target'])
    except getopt.GetoptError as err:
        print(err)
        usage()
        sys.exit()
    target = None
    source = None
    beta = False

    for o, a in opts:
        if o in ("-h", "--help"):
            usage()
        if o in ("-b", "--beta"):
            beta = True
        elif o in ("-s", "--source"):
            source = Path(a)
        elif o in ("-t", "--target"):
            target = Path(a)
        else:
            usage()
            sys.exit()
    if checkTarget(target) and checkSource(source):

        target = target.joinpath("public")
        source_zip = ZipFile(source)
        if do_files_collide(source_zip, target, beta):
            print("The given resource zip contains files which are already currently installed")
            sys.exit()
        delete_old_files(target, beta)
        copy_new_files(source_zip, target, beta)
        copy_into_template(source_zip, target, beta)

    else:
        usage()
        sys.exit()


def delete_old_files(dest: Path, beta = False):
    manifest_path = get_manifest_path(dest, beta)
    if manifest_path.exists():
        with manifest_path.open("r") as f:
            manifest = json.load(f)

        file_gen = iter_manifest_files(manifest)
        for f in file_gen:
            if f[0] != "index.html":
                p = dest.joinpath(f[1])
                if p.is_file():
                    os.remove(p)
                for p in p.parents:
                    if not p.is_dir():
                        continue
                    contains_items = any(p.iterdir())
                    if contains_items:
                        break
                    else:
                        p.rmdir()
    to_delete = basic_files
    to_delete += "asset-manifest.json" # make sure old versions of format delete asset-manifest.json

    for f in to_delete:
        p = dest.joinpath(f)
        if p.is_file():
            os.remove(p)


def copy_new_files(archive: ZipFile, dest: Path, beta = False):
    to_copy = basic_files
    for f in to_copy:
        if (beta and f == "manifest.json"):
            continue # keep main manifest.json
        archive.extract(f, dest)
    with archive.open(manifest_file_name) as f:
        manifest = json.load(f)
    for f in iter_manifest_files(manifest):
        archive.extract(f[1], dest)


def copy_into_template(archive: ZipFile, dest: Path, beta = False):
    with archive.open("index.html") as f:
        text = map(lambda x: x.decode("utf-8"), f.readlines())
        with get_frontend_path(dest, beta).open("w") as frontend:
            frontend.writelines(text)

    with archive.open(manifest_file_name) as f:
        text = map(lambda x: x.decode("utf-8"), f.readlines())

        with get_manifest_path(dest, beta).open("w") as frontend:
            frontend.writelines(text)

def do_files_collide(new_archive: ZipFile, dest: Path, beta = False):
    with new_archive.open(manifest_file_name) as f:
        manifest = json.load(f)
    new_file_names = set(map(lambda x: x[1], manifest))
    old_manifest_path = get_manifest_path(dest, not beta)
    if not old_manifest_path.exists():
        return False

    with old_manifest_path.open("r") as f:
        old_manifest = json.load(f)

    old_file_names = set(map(lambda x: x[1], old_manifest))
    return not new_file_names.isdisjoint(old_file_names)


def get_manifest_path(dest: Path, beta = False):

    manifest_name = "asset-manifest"
    if(beta):
        manifest_name += "-beta"
    manifest_name += '.json'
    return dest.parent.joinpath("resources", "json", manifest_name)

def get_frontend_path(dest: Path, beta = False):

    manifest_name = "frontend"
    if(beta):
        manifest_name += "-beta"
    manifest_name += '.blade.php'
    return dest.parent.joinpath("resources", "views", manifest_name)

def iter_manifest_files(manifest):
    for f in manifest["files"].items():
        if f[0] != "index.html":
            yield f[0], f[1][1:]  # remove leading slash


def checkTarget(target_path: Path):
    if target_path is None:
        return False
    public = target_path.joinpath("public")
    return target_path.is_dir() and public.exists() and public.is_dir()


def checkSource(source_path: Path):
    if source_path is None:
        return False
    return source_path.is_file() and zipfile.is_zipfile(source_path)


if __name__ == "__main__":
    main(sys.argv[1:])
