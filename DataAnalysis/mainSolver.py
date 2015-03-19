from BinaryMap import BinaryMap
from HeatMap import HeatMap
from sets import Set
from CacheLoader import CacheLoader
from itertools import combinations

imageNumber = 0

if __name__ == '__main__':
    binaryMaps = CacheLoader(imageNumber)
    l = []
    for i in range(10):
        for subset in combinations(range(10),i):
            print(subset)
    
    
