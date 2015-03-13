from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set

def printBinaryMaps(binaryMaps):
    print(len(binaryMaps))
    for binaryMapsImage in binaryMaps:
        print(len(binaryMapsImage))
        for binaryMap in binaryMapsImage:
            print(len(binaryMap.interiorPoints))
            for x,y in binaryMap.interiorPoints:
                print(str(x) + " " + str(y))


if __name__ == '__main__':
    numImages = []
    polygons = []
    content = []
    with open("resultsBlurred.txt") as f:
        content = f.readlines()

    binaryMaps = []
    #first need to cache all Binary Maps
    for imageNumber in range(11):
        # very inefficient because the file gets read too many times
        binaryMapsImage = []
        for line in content:
            if line.startswith("Image" +
                               str(imageNumber) + "-") is True:
                binaryMap = BinaryMap("../results/BlurredContours/" +
                                            line.strip('\n'))
                if binaryMap.junk == False:
                    binaryMapsImage.append(binaryMap)
        binaryMaps.append(binaryMapsImage)

    
    printBinaryMaps(binaryMaps)



