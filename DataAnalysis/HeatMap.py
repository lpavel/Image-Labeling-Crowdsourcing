

class HeatMap:

    def __init__(self, image_number):
        self.files = []
        
        with open(fname) as f:
            content = f.readlines()
        for line in content:
            if line.startswith(image_number + "-") is True:
                self.files.append(line)
                

    def process_images():
        for file in self.files:
            with open(file) as f:
                json_str = f.readline()
                
            
        


if __name__ == '__main__':
    heat_map = HeatMap("Image1")
    heat_map.process_images()
