import json
from pprint import pprint

class Polygon:

    def __init__(self, imageName):
        jsonData = open(imageName)
        data = json.load(jsonData)
        self.points = []
        self.edges  = []
        
#        pprint(data)
        for contour in data:
            for line in contour:
                self.points.append(( float(line["X"]), float(line["Y"])))

        print(self.points)
        for i in range(1,len(self.points)):
            self.edges.append((self.points[i-1], self.points[i]))
        self.edges.append((self.points[-1], self.points[0]))
        print(self.edges)
        self.is_junk()

    def ccw(self,p1,p2,p3):
        p1X, p1Y = p1
        p2X, p2Y = p2
        p3X, p3Y = p3        
        return (p3Y-p1Y) * (p2X-p1X) > (p2Y-p1Y) * (p3X-p1X)
        
    def intersect(self, edge1, edge2):
        p1,p2 = edge1
        p3,p4 = edge2
        return self.ccw(p1,p3,p4) != self.ccw(p2,p3,p4) and self.ccw(p1,p2,p3) != self.ccw(p1,p2,p4)
        
    def is_junk(self):
        intersections = 0
        for i in range(len(self.edges) - 1):
            for j in range(i+2, len(self.edges)):
                if self.intersect(self.edges[i], self.edges[j]) == True:
                    intersections = intersections + 1

        if intersections > 3:
            self.junk = True
        else:
            self.junk = False
        print(self.junk)
        
if __name__ == '__main__':
    p = Polygon('../results/BlurredContours/Image0-10d2423eac08988b513ebbff7b6cd207.json')
    
