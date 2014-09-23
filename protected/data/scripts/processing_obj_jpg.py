import os
import PhotoScan
import shutil
import errno

def make_dir(path):
    try:
        os.makedirs(path)
    except OSError as exception:
        if exception.errno != errno.EEXIST:
            raise

def main():

	print("Script started")

	doc = PhotoScan.app.document
	chunk = PhotoScan.Chunk()
	chunk.label = "New Chunk"
	doc.chunks.add(chunk)

	#path_photos = PhotoScan.app.getExistingDirectory("Specify folder with input photos:")
	path_photos = "/var/www/modcopter/uploads/1-modCopter/"
	if not path_photos:
		print("Script aborted")
		return -1

	#create output folder
	make_dir(path_photos + 'output');

	#adding photos
	image_list = os.listdir(path_photos)
	for photo in image_list:
		if ("jpg" or "jpeg" or "tif") in photo.lower():
			chunk.photos.add(path_photos + photo)

	#loading GPS data from EXIF tags
	#chunk.ground_control.loadExif()
	#chunk.ground_control.apply()
	#PhotoScan.app.update()

	#align photos
	#chunk.matchPhotos(accuracy = "medium", preselection = "ground control", point_limit = 40000)
	chunk.matchPhotos(accuracy = "low", preselection = "generic", point_limit = 40000)
	chunk.alignPhotos()

	#build dense cloud
	chunk.buildDenseCloud(quality = "low", filter = "aggressive")

	#build mesh
	#chunk.buildModel(surface = "height field", source = "dense", interpolation = "enabled", faces = "high")
	chunk.buildModel(surface = "arbitrary", source = "dense", interpolation = "enabled", faces = "high")

	#build texture
	#chunk.buildTexture(mapping = "orthophoto", blending = "mosaic", color_correction = False, size = 8192)
	chunk.buildTexture(mapping = "generic", blending = "mosaic", color_correction = False, size = 8192)

	#doc.save(path_photos + "doc1.psz")
	chunk.exportModel(path_photos + "output/output.obj", texture_format="jpg", format="obj")
	chunk.exportModel(path_photos + "output/output.dxf", texture=False, format="dxf")
	#make archive with the output
	shutil.make_archive(path_photos + "output", "zip", path_photos + "output")

	PhotoScan.app.update()
	print("Script finished")
	return 1


PhotoScan.app.addMenuItem("Custom menu/Process model", main)