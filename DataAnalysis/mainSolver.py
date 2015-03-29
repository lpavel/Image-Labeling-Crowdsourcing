from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set
from CacheLoader import CacheLoader
from itertools import combinations

imageNumber = 10
truthFileName = '../results/GroundTruths/GroundTruth-'


from operator import mul    # or mul=lambda x,y:x*y
from fractions import Fraction

def nCk(n,k):
      return int( reduce(mul, (Fraction(n-i, i+1) for i in range(k)), 1) )

if __name__ == '__main__':
    '''
    # this thing can be automated for all images
    cacheLoader = CacheLoader(imageNumber)
    binaryMaps  = cacheLoader.binaryMaps
    heatMap = HeatMap(binaryMaps)
    heatMap.createBinaryFromHeat()
    groundTruthMap = BinaryMap(truthFileName + str(imageNumber) + '.json')
    #print(groundTruthMap.interiorPoints)
    accuracy = heatMap.binaryMap.compareBinaryMaps(groundTruthMap)

    print(accuracy)
    '''
        
#    '''
    # here will be the code for number of hits for accuracy
    # this code runs
    cacheLoader = CacheLoader(imageNumber)
    binaryMaps  = cacheLoader.binaryMaps
    groundTruthMap = BinaryMap(truthFileName + str(imageNumber) + '.json')
    accuracies = []
    totalMaps = len(binaryMaps)
    for i in range(1,totalMaps+1):
        totalAccuracy = 0
        for subset in combinations(range(len(binaryMaps)), i):
            binaryMapsSubset = []
            for j in subset:
                binaryMapsSubset.append(binaryMaps[j])
            heatMap = HeatMap(binaryMapsSubset)
            heatMap.createBinaryFromHeat()
            totalAccuracy += heatMap.binaryMap.compareBinaryMaps(groundTruthMap)
        print(float(totalAccuracy) / nCk(totalMaps,i))
        accuracies.append(float(totalAccuracy) / nCk(totalMaps,i))

    print(accuracies)        
#    '''

    '''
    # this script will run all of them at ones

    accuracies = []
    for imageNumber in range(10):
        binaryMaps = CacheLoader(imageNumber)
        heatMap = HeatMap(binaryMaps)
        groundTruthMap = BinaryMaps(truthFileName + str(imageNumber))
        accuracies.append(heatMap.compareBinaryMaps(groundTruthMap))
    print(accuracies)
    '''
    
