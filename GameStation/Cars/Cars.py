import os
import pygame
import sys
from pygame.locals import *
import random

class Cars:
    def __init__(self, screen):
        self.running = True
        self.screen = screen
        self.width = screen.get_width()
        self.height = screen.get_height()
        self.clock = pygame.time.Clock()

        font_path = os.path.join('./Others/assets/font.ttf')
        self.font_text = pygame.font.Font(font_path, 30)
        self.font_gameover = pygame.font.Font(font_path, 15)

        self.explosion_sound = pygame.mixer.Sound('Cars/explosion.mp3')
        self.point_sound = pygame.mixer.Sound('Cars/bip.mp3')
        self.ok = 0

    def run(self):
        road_width = 300
        marker_width = 10
        marker_height = 50

        left_lane = 150
        center_lane = 250
        right_lane = 350
        lanes = [left_lane, center_lane, right_lane]

        road = (100, 0, road_width, self.height)
        left_edge_marker = (95, 0, marker_width, self.height)
        right_edge_marker = (395, 0, marker_width, self.height)

        image_filenames = ['pickup_truck.png', 'semi_trailer.png', 'taxi.png', 'van.png']
        vehicle_images = [pygame.image.load('Cars/images/' + fn) for fn in image_filenames]
        crash = pygame.image.load('Cars/images/crash.png')
        crash_rect = crash.get_rect()

        running = True
        while running:
            player_x = 250
            player_y = 400
            lane_marker_move_y = 0
            gameover = False
            speed = 2
            score = 0

            player_group = pygame.sprite.Group()
            vehicle_group = pygame.sprite.Group()

            player = PlayerVehicle(player_x, player_y)
            player_group.add(player)

            while True:
                self.clock.tick(120)
                for event in pygame.event.get():
                    if event.type == pygame.QUIT or (event.type == pygame.KEYDOWN and event.key == pygame.K_ESCAPE):
                        self.exit_game()
                    if event.type == KEYDOWN:
                        if gameover and event.key == K_SPACE:
                            return
                        else:
                            if event.key == K_LEFT and player.rect.center[0] > left_lane:
                                player.rect.x -= 100
                            elif event.key == K_RIGHT and player.rect.center[0] < right_lane:
                                player.rect.x += 100

                self.screen.fill((255, 200, 220))
                pygame.draw.rect(self.screen, 'gray', road)
                pygame.draw.rect(self.screen, 'purple', left_edge_marker)
                pygame.draw.rect(self.screen, 'purple', right_edge_marker)

                if not gameover:
                    lane_marker_move_y += speed * 2
                    if lane_marker_move_y >= marker_height * 2:
                        lane_marker_move_y = 0
                for y in range(marker_height * -2, self.height, marker_height * 2):
                    pygame.draw.rect(self.screen, 'white', (left_lane + 45, y + lane_marker_move_y, marker_width, marker_height))
                    pygame.draw.rect(self.screen, 'white', (center_lane + 45, y + lane_marker_move_y, marker_width, marker_height))

                player_group.draw(self.screen)

                if not gameover:
                    if len(vehicle_group) < 2:
                        add_vehicle = all(v.rect.top >= v.rect.height * 1.5 for v in vehicle_group)
                        if add_vehicle:
                            lane = random.choice(lanes)
                            image = random.choice(vehicle_images)
                            vehicle = Vehicle(image, lane, self.height / -2)
                            vehicle_group.add(vehicle)
                    for vehicle in vehicle_group:
                        vehicle.rect.y += speed
                        if vehicle.rect.top >= self.height:
                            vehicle.kill()
                            score += 1
                            self.point_sound.play()
                            if score > 0 and score % 5 == 0:
                                speed += 1
                    if pygame.sprite.spritecollide(player, vehicle_group, True):
                        gameover = True
                        crash_rect.center = [player.rect.center[0], player.rect.top]

                vehicle_group.draw(self.screen)

                text = self.font_text.render('Score: ' + str(score), True, 'white')
                text_rect = text.get_rect(center=(600, 250))
                self.screen.blit(text, text_rect)

                if gameover:
                    if self.ok == 0:
                        self.explosion_sound.play()
                        self.ok = 1
                    self.screen.blit(crash, crash_rect)
                    pygame.draw.rect(self.screen, 'red', (0, 50, self.width, 100))
                    text = self.font_gameover.render('Game over. Press SPACE to return', True, 'white')
                    text_rect = text.get_rect(center=(self.width / 2, 100))
                    self.screen.blit(text, text_rect)

                pygame.display.update()

    def exit_game(self):
        self.running = False
        pygame.quit()
        sys.exit()

class Vehicle(pygame.sprite.Sprite):
    def __init__(self, image, x, y):
        super().__init__()
        image_scale = 45 / image.get_rect().width
        new_width = int(image.get_rect().width * image_scale)
        new_height = int(image.get_rect().height * image_scale)
        self.image = pygame.transform.scale(image, (new_width, new_height))
        self.rect = self.image.get_rect(center=[x, y])

class PlayerVehicle(Vehicle):
    def __init__(self, x, y):
        image = pygame.image.load('Cars/images/car.png')
        super().__init__(image, x, y)
