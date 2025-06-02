import pygame
class ImageButton:
    def __init__(self, image_path, pos, scale =1):
        self.image = pygame.image.load(image_path).convert_alpha()
        if scale != 1:
            width = int(self.image.get_width() *scale)
            height = int(self.image.get_height() * scale)
            self.image = pygame.transform.scale(self.image, (width, height))
        self.rect = self.image.get_rect(center = pos)

    def draw(self, screen):
        screen.blit(self.image, self.rect)

    def is_clicked(self, mouse_pos):
        return self.rect.collidepoint(mouse_pos)