import getopt
import json
import sys
from pathlib import Path
import zipfile
from zipfile import ZipFile
import os

basic_files = ["asset-manifest.json", "manifest.json", "robots.txt"]

manifest_file_name = "asset-manifest.json"


def usage():
    print('\nUsage -h -s [path to zip archive] -t [path to laravel project]\n\n'
          '\t -h --help \t Show this message \n'
          '\t -s --source \t Path of the build react project as zip archive \n'
          '\t -t --target \t Path to the root of the laravel project')


def main(argv):
    try:
        opts, args = getopt.getopt(argv, 'hs:t:', ['help', 'source', 'target'])
    except getopt.GetoptError as err:
        print(err)
        usage()
        sys.exit()
    target = None
    source = None

    for o, a in opts:
        if o in ("-h", "--help"):
            usage()
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
        delete_old_files(target)
        copy_new_files(source_zip, target)
        copy_index(source_zip, target)



    else:
        usage()
        sys.exit()


def delete_old_files(manifest_folder: Path):
    manifest_path = manifest_folder.joinpath(manifest_file_name)
    if manifest_path.exists():
        with manifest_path.open() as f:
            manifest = json.load(f)

        file_gen = iter_manifest_files(manifest)
        for f in file_gen:
            if f[0] != "index.html":
                p = manifest_folder.joinpath(f[1])
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

    for f in to_delete:
        p = manifest_folder.joinpath(f)
        if p.is_file():
            os.remove(p)


def copy_new_files(archive: ZipFile, dest: Path):
    to_copy = basic_files
    for f in to_copy:
        archive.extract(f, dest)
    with archive.open(manifest_file_name) as f:
        manifest = json.load(f)
    for f in iter_manifest_files(manifest):
        archive.extract(f[1], dest)


def copy_index(archive: ZipFile, dest: Path):
    with archive.open("index.html") as f:
        text = map(lambda x: x.decode("utf-8"), f.readlines())
        with dest.parent.joinpath("resources", "views", "frontend.blade.php").open("w") as frontend:
            frontend.writelines(text)


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
